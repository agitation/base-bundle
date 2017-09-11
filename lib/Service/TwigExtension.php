<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Twig_Extension;
use Twig_SimpleFunction;

class TwigExtension extends Twig_Extension
{
    private $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function getName()
    {
        return 'agit.base';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('getAppUrlBase', [$this, 'getAppUrlBase'])
        ];
    }

    public function getAppUrlBase()
    {
        return $this->urlService->createAppUrl('/');
    }
}
