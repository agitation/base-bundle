<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Tests\Validator;

use Agit\BaseBundle\Validation\ObjectValidator;

class ObjectValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestValidateGood
     */
    public function testValidateGood($value, array $properties = [], $onlyGivenProperties = true)
    {
        try {
            $success = true;
            $objectValidator = new ObjectValidator();
            $objectValidator->validate($value, $properties, $onlyGivenProperties);
        } catch (\Exception $e) {
            p($e->getMEssage());
            $success = false;
        }

        $this->assertTrue($success);
    }

    /**
     * @dataProvider providerTestValidateBad
     */
    public function testValidateBad($value, array $properties = [], $onlyGivenProperties = true)
    {
        $this->setExpectedException('\Agit\BaseBundle\Exception\InvalidValueException');
        $objectValidator = new ObjectValidator();
        $objectValidator->validate($value, $properties, $onlyGivenProperties);
    }

    public function providerTestValidateGood()
    {
        return [
            [(object) []],
            [new \Exception()],
            [(object) ['foo' => 'bar'], ['foo']],
            [(object) ['foo' => 'bar', 'foo2' => 'bar2'], ['foo'], false],
        ];
    }

    public function providerTestValidateBad()
    {
        return [
            [[]],
            [15],
            [(object) ['foo' => 'bar'], ['bar']],
            [(object) ['foo' => 'bar', 'foo2' => 'bar2'], ['foo'], true],
        ];
    }
}
