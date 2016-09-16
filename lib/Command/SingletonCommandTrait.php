<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Command;

trait SingletonCommandTrait
{
    private $selfFileHandle; // used for "singleton" locks

    // use this to allow only one instance of this command
    protected function flock($scriptfile)
    {
        $this->selfFileHandle = fopen($scriptfile, 'r');
        $ok = flock($this->selfFileHandle, LOCK_EX | LOCK_NB);

        if (! $ok) {
            print "Another instance is already running.\n";
        }

        return $ok;
    }
}
