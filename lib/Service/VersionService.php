<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Doctrine\Common\Cache\Cache;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class VersionService implements VersionStrategyInterface, CacheWarmerInterface
{
    const CACHE_FILE = 'version';

    const DEFAULT_VERSION = 'dev';

    private $cache;

    private $env;

    public function __construct(Cache $cache, string $env)
    {
        $this->cache = $cache;
        $this->env = $env;
    }

    public function getVersion($path)
    {
        return $this->cache->fetch(self::CACHE_FILE) ?: self::DEFAULT_VERSION;
    }

    public function applyVersion($path)
    {
        return $path . '?' . $this->getVersion($path);
    }

    /**
     * @param mixed $cacheDir
     * @param mixed $_ignored
     */
    public function warmUp($_ignored)
    {
        $version = $this->env === 'dev' ? self::DEFAULT_VERSION : (string)time();
        $this->cache->save(self::CACHE_FILE, $version);
    }

    /**
     * required by CacheWarmerInterface.
     */
    public function isOptional()
    {
        return true;
    }
}
