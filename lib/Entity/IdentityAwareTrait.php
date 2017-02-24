<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

trait IdentityAwareTrait
{
    protected static $entityClassName;

    // NOTE: The $id property and its annotations must be defined in a "child" trait or an entity.

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __debugInfo()
    {
        return [$this->__toString()]; // must for some reason return an array :(
    }

    /**
     * This is mostly useful for comparison and sorting.
     */
    public function __toString()
    {
        return $this->getEntityClass() . '-' . (string) $this->getId();
    }

    public function getEntityClass()
    {
        if (! self::$entityClassName) {
            $className = get_class($this);

            if (strpos($className, 'Prox') !== false) {
                $className = get_parent_class($this);
            }

            if (strpos($className, '\\') !== false) {
                $className = substr(strrchr($className, "\\"), 1);
            }

            self::$entityClassName = $className;
        }

        return self::$entityClassName;
    }

    // can be overridden with something that returns the natural, localized entity name.
    public function getEntityName()
    {
        return $this->getEntityClass();
    }
}
