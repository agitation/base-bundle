<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle
{
    use Symfony\Component\HttpKernel\Bundle\Bundle;

    class AgitBaseBundle extends Bundle
    {
    }
}

// quick and dirty variable dumper

namespace
{
    function p()
    {
        if (PHP_SAPI !== 'cli')
        {
            @header('Content-Type: text/plain; charset=UTF-8');
        }

        foreach (func_get_args() as $arg)
        {
            if ($arg === null || is_bool($arg))
            {
                var_dump($arg);
            }
            else
            {
                print_r($arg);
            }

            echo "\n\n";
        }
    }
}
