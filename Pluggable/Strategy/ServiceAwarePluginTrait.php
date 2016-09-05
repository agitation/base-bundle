<?php
/**
 * @package    agitation/pluggable
 * @link       http://github.com/agitation/AgitPluggableBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\PluggableBundle\Strategy;

use Agit\BaseBundle\Exception\InternalErrorException;

trait ServiceAwarePluginTrait
{
    private $services = [];

    private $parameters = [];

    final public function setService($name, $instance)
    {
        $this->services[$name] = $instance;
    }

    final public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    final protected function getService($name)
    {
        if (!isset($this->services[$name]) || !is_object($this->services[$name]))
            throw new InternalErrorException("Service `$name` was not injected.");

        return $this->services[$name];
    }

    final protected function getParameter($name)
    {
        if (!isset($this->parameters[$name]))
            throw new InternalErrorException("Parameter `$name` was not injected.");

        return $this->parameters[$name];
    }
}
