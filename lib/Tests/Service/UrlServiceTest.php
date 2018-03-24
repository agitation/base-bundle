<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Tests\Service;

use Agit\BaseBundle\Service\UrlService;

class UrlServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAppUrl()
    {
        $urlService = $this->getServiceInstance();

        $this->assertSame(
            '/foo/bar?a=b&c=d',
            $urlService->createAppUrl('/foo/bar', ['a' => 'b', 'c' => 'd'])
        );
    }

    public function testAppend()
    {
        $urlService = $this->getServiceInstance();

        $this->assertSame('/test?a=b&c=d', $urlService->append('/test', ['a' => 'b', 'c' => 'd']));
        $this->assertSame('/test?a=b&amp;c=d', $urlService->append('/test', ['a' => 'b', 'c' => 'd'], 'html'));
        $this->assertSame('/test?a=b%26c=d', $urlService->append('/test', ['a' => 'b', 'c' => 'd'], 'url'));
        $this->assertSame('/test?a[]=a1&a[]=b1&c=d', $urlService->append('/test', ['a' => ['a1', 'b1'], 'c' => 'd']));
    }

    private function getServiceInstance()
    {
        return new UrlService();
    }
}
