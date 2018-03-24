<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Tool;

use RuntimeException;

class ClassChecker
{
    /**
     * Checks that a passed argument is an array and every array member is an
     * instance of $className. Basically the same as type-hinting for Class[].
     *
     * @param array|ArrayObject $array
     * @param string            $className
     *
     * @throws RuntimeException
     */
    public static function isObjectArray($array, $className)
    {
        if (! is_array($array))
        {
            throw new RuntimeException('The variable must be an array.');
        }

        foreach ($array as $value)
        {
            if (! ($value instanceof $className))
            {
                throw new RuntimeException(sprintf('The variable must be an instance of %s.', $className));
            }
        }
    }
}
