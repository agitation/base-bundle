<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Annotation;

use Agit\BaseBundle\Exception\InternalErrorException;

trait AnnotationTrait
{
    public function __construct(array $options = null)
    {
        $this->setOptions($options);
    }

    public function setOptions(array $options = null)
    {
        if ($options && count($options)) {
            foreach ($options as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    public function getOptions()
    {
        $options = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ($key[0] !== '_') {
                $options[$key] = $value;
            }
        }

        return $options;
    }

    public function has($key)
    {
        return is_string($key) && strpos($key, '_') !== 0 && property_exists($this, $key);
    }

    public function set($key, $value)
    {
        if (! property_exists($this, $key)) {
            throw new InternalErrorException(sprintf('Annotation property "%s" does not exist.', $key));
        }

        if (strpos($key, '_') === 0) {
            throw new InternalErrorException('Internal properties must not be modified via annotations.');
        }

        $this->$key = $value;
    }

    public function get($key)
    {
        if ($key[0] === '_') {
            throw new InternalErrorException('Internal properties must not be read through this method.');
        }

        if (! property_exists($this, $key)) {
            throw new InternalErrorException(sprintf('Annotation property "%s" does not exist.', $key));
        }

        return $this->$key;
    }
}
