<?php
/**
 * @package    agitation/pluggable
 * @link       http://github.com/agitation/AgitPluggableBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\PluggableBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Agit\CommonBundle\Command\SingletonCommandTrait;

class LoadPluginsCommand extends ContainerAwareCommand
{
    use SingletonCommandTrait;

    protected function configure()
    {
        $this
            ->setName('agit:pluggable:process')
            ->setDescription('Loads and registers all pluggable services and their plugins.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->flock(__FILE__)) return;

        $this->getContainer()->get('agit.pluggable.processor')->processPlugins();
    }
}
