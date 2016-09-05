<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Tests\Validator;

use Agit\BaseBundle\Validation\RegexValidator;

class RegexValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestValidateGood
     */
    public function testValidateGood($value, $regex)
    {
        try {
            $success = true;
            $regexValidator = new RegexValidator();
            $regexValidator->validate($value, $regex);
        } catch (\Exception $e) {
            $success = false;
        }

        $this->assertTrue($success);
    }

    /**
     * @dataProvider providerTestValidateBad
     */
    public function testValidateBad($value, $regex)
    {
        $this->setExpectedException('\Agit\BaseBundle\Exception\InvalidValueException');
        $regexValidator = new RegexValidator();
        $regexValidator->validate($value, $regex);
    }

    public function providerTestValidateGood()
    {
        return [
            ['abc', '|^[a-z]*$|'],
            ['20', '/\d$/'],
            ['öäü', '|\pL|u']
        ];
    }

    public function providerTestValidateBad()
    {
        return [
            ['abc0', '|^[a-z]*$|'],
            ['abc', '|\d|'],
            [mb_convert_encoding('öäü', 'ISO-8859-1', 'UTF-8'), '|\pL|u']
        ];
    }
}
