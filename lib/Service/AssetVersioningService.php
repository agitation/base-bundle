<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class AssetVersioningService implements VersionStrategyInterface
{
    private $env;

    public function __construct($env)
    {
        $this->env = $env;
    }

    public function getVersion($path)
    {
        p($path);

        return $this->env === "dev" ? "foobar" : (string)time();
    }

    public function applyVersion($path)
    {
        return $path . "?" . $this->getVersion($path);
    }
}
