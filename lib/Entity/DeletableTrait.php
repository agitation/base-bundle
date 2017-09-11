<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Provides the capability for soft-deleting entities.
 * Must be used together with the DeletableInterface to make sense.
 */
trait DeletableTrait
{
    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $deleted = false;

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Get deleted.
     *
     * @return smallint
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Get deleted.
     *
     * @return smallint
     */
    public function isDeleted()
    {
        return $this->deleted;
    }
}
