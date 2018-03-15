<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Tool;

class StringHelper
{
    public static function getBareClassName($class)
    {
        if (is_object($class))
        {
            $class = get_class($class);
        }

        return substr(strrchr($class, '\\'), 1);
    }

    public static function createRandomString($length = 10, $sets = 'uln')
    {
        $availableSets =
        [
            'u' => 'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'l' => 'abcdefghijklmnpqrstuvwxyz',
            'n' => '23456789',
            'c' => '§$%/()[]-@<>|'
        ];

        $string = '';
        $letters = '';

        foreach (str_split($sets) as $set)
        {
            $letters .= $availableSets[$set];
        }

        $max = strlen($letters) - 1;

        for ($i = 0; $i < $length; $i++)
        {
            $string .= $letters[mt_rand(0, $max)];
        }

        return $string;
    }
}
