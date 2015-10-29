<?php
/**
 * @package    agitation/core
 * @link       http://github.com/agitation/AgitCoreBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\CoreBundle\Pluggable\Strategy\Seed;

use Symfony\Component\EventDispatcher\Event;

/**
 * Data container for seed objects.
 */
class SeedRegistrationEvent extends Event
{
    public function __construct(SeedProcessor $Processor)
    {
        $this->Processor = $Processor;
    }

    public function createContainer()
    {
        return new SeedData();
    }

    public function register(SeedData $SeedData)
    {
        return $this->Processor->register($SeedData);
    }
}