<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

interface NameInterface
{
    public function setName($name);

    public function getName();
}
