<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

interface IdentityInterface
{
    public function __toString();
    public function getId();

    public static function getEntityClass();

    public static function getEntityClassName();
}
