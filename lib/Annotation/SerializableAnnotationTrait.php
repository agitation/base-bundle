<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Annotation;

trait SerializableAnnotationTrait
{
    use AnnotationTrait;

    public function serialize()
    {
        return serialize($this->getOptions());
    }

    public function unserialize($options)
    {
        return $this->setOptions(unserialize($options));
    }
}
