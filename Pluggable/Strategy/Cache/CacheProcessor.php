<?php
/**
 * @package    agitation/core
 * @link       http://github.com/agitation/AgitCoreBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\CoreBundle\Pluggable\Strategy\Cache;

use Agit\CoreBundle\Exception\InternalErrorException;
use Doctrine\Common\Cache\CacheProvider;
use Agit\CoreBundle\Pluggable\Strategy\ProcessorInterface;

/**
 * Processes registered objects
 */
class CacheProcessor implements ProcessorInterface
{
    // caching implementation
    private $cacheProvider;

    // the list of available plugins to services
    private $plugins = [];

    protected $registrationTag;

    public function __construct(CacheProvider $cacheProvider, $registrationTag)
    {
        $this->cacheProvider = $cacheProvider;
        $this->registrationTag = $registrationTag;
    }

    public function getRegistrationTag()
    {
        return $this->registrationTag;
    }

    public function createRegistrationEvent()
    {
        return new CacheRegistrationEvent($this);
    }

    public function register(CacheData $cacheData, $priority)
    {
        $this->addPlugin($cacheData->getId(), $cacheData->getData());
    }

    protected function addPlugin($id, $data)
    {
        $this->plugins[$id] = $data;
    }

    public function process()
    {
        $this->getCacheProvider()->save($this->getRegistrationTag(), $this->plugins);
    }

    public function getPriority()
    {
        return 1;
    }

    protected function getCacheProvider()
    {
        return $this->cacheProvider;
    }
}
