<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Annotation;

interface AnnotationInterface
{
    public function setOptions(array $options = null);

    public function getOptions();

    public function has($key);

    public function set($key, $value);

    public function get($key);
}
