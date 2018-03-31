<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function fill($entity, array $data, array $allowedFields)
    {
        $class = get_class($entity);
        $meta = $this->entityManager->getClassMetadata($class);

        foreach ($data as $key => $value)
        {
            if (!in_array($key, $allowedFields))
            {
                throw new BadRequestHttpException("Cannot autofill `$key` key for $class.");
            }

            if ($meta->hasField($key) || ($mapping = $meta->getAssociationMapping($key)) && $mapping['type'] & ClassMetadataInfo::TO_ONE)
            {
                $meta->setFieldValue($entity, $key, $value);
            }
        }
    }

    public function validate($entity)
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0)
        {
            $error = $errors->get(0);
            $field = $error->getPropertyPath();

            throw new BadRequestHttpException(sprintf('Error%s: %s', $field ? " in field `$field`" : '', $error->getMessage()));
        }
    }

    protected function saveEntity($entity, array $data, array $allowedFields)
    {
        $this->fill($entity, $data, $allowedFields);
        $this->validate($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
