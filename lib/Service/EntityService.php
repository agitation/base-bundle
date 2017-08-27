<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Agit\BaseBundle\Entity\IdentityInterface;
use Agit\BaseBundle\Exception\InvalidEntityFieldException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\UnitOfWork;

class EntityService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Fills an entity with plain data.
     *
     * ATTENTION: This method does not use the entity’s setters.
     *
     * @param IdentityInterface $entity
     * @param array             $data
     * @param array             $protectedFields
     */
    public function updateEntity(IdentityInterface $entity, array $data, array $protectedFields = [])
    {
        $em = $this->entityManager;

        // sometimes, we have stale entities in memory/cache
        if ($this->entityManager->getUnitOfWork()->getEntityState($entity) === UnitOfWork::STATE_MANAGED) {
            $em->refresh($entity);
        }

        foreach ($data as $field => $value) {
            if ($field === "id" || in_array($field, $protectedFields)) {
                throw new InvalidEntityFieldException(sprintf("The `%s` field cannot be updated with this method.", $field));
            }

            $meta = $em->getClassMetadata(get_class($entity));

            if ($meta->hasField($field)) {
                $meta->setFieldValue($entity, $field, $value);
            } elseif ($meta->hasAssociation($field)) {
                $mapping = $meta->getAssociationMapping($field);
                $targetEntity = $mapping["targetEntity"];

                if ($mapping["type"] & ClassMetadataInfo::TO_ONE) {
                    if (is_scalar($value)) {
                        $value = $em->getReference($targetEntity, $value);
                    }

                    $meta->setFieldValue($entity, $field, $value ?: null);
                } elseif ($mapping["type"] & ClassMetadataInfo::TO_MANY && is_array($value)) {
                    $child = $meta->getFieldValue($entity, $field);
                    $child->clear();

                    foreach ($value as $val) {
                        if (is_scalar($val)) {
                            $val = $em->getReference($targetEntity, $val);
                        }

                        $child->add($val);
                    }
                }
            } else {
                throw new InvalidEntityFieldException(sprintf("Invalid entity field: %s", $field));
            }
        }
    }
}
