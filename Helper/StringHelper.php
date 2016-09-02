<?php
/**
 * @package    agitation/common
 * @link       http://github.com/agitation/AgitBaseBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Helper;

class StringHelper
{
    static public function getBareClassName($class)
    {
        if (is_object($class))
            $class = get_class($class);

        return substr(strrchr($class, "\\"), 1);
    }

    static public function createRandomString($length = 10, $sets = "uln")
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

        foreach (str_split($sets) as $set)
            $letters .= $availableSets[$set];

        $max = strlen($letters) - 1;

        for ($i = 0; $i < $length; $i++)
            $string .= $letters[rand(0, $max)];

        return $string;
    }

    static public function generateCompositeCode($id, $code, $padding = 7, $prefix = "")
    {
        return $prefix . sprintf("%0{$padding}d-%s", $id, $code);
    }
}
