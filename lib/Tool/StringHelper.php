<?php

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
        if (is_object($class)) {
            $class = get_class($class);
        }

        return substr(strrchr($class, "\\"), 1);
    }

    public static function createRandomString($length = 10, $sets = "uln")
    {
        $availableSets =
        [
            "u" => "ABCDEFGHIJKLMNPQRSTUVWXYZ",
            "l" => "abcdefghijklmnopqrstuvwxyz",
            "n" => "123456789",
            "c" => "§$%/()[]-@<>|"
        ];

        $string = "";
        $letters = "";

        foreach (str_split($sets) as $set) {
            $letters .= $availableSets[$set];
        }

        $max = strlen($letters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $string .= $letters[rand(0, $max)];
        }

        return $string;
    }

    public static function generateCompositeCode($id, $code, $padding = 7, $prefix = "")
    {
        return $prefix . sprintf("%0{$padding}d-%s", $id, $code);
    }
}
