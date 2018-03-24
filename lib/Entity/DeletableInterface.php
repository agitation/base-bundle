<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

/**
 * Indicates that an entity can be soft-deleted.
 * Should be used together with the DeletableTrait.
 */
interface DeletableInterface
{
    public function setDeleted($deleted);

    public function isDeleted();
}
