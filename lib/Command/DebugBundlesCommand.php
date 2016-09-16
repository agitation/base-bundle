<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DebugBundlesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('debug:bundles')
            ->setDescription('Dumps a list of all bundles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        foreach ($container->getParameter('kernel.bundles') as $alias => $namespace) {
            $output->writeln($alias);
        }
    }
}
