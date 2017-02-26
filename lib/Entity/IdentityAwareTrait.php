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
    protected static $entityClass;

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
        return self::getEntityClass() . '-' . (string) $this->getId();
    }

    public static function getEntityClass()
    {
        if (! self::$entityClass) {
            $class = get_called_class();

            if (strpos($class, 'Prox') !== false) {
                $class = get_parent_class($class);
            }

            if (strpos($class, '\\') !== false) {
                $class = substr(strrchr($class, "\\"), 1);
            }

            self::$entityClass = $class;
        }

        return self::$entityClass;
    }

    // can be overridden with something that returns the natural, localized entity name.
    public static function getEntityClassName()
    {
        return self::getEntityClass();
    }
}
