<?php
/**
 * @package    agitation/validation
 * @link       http://github.com/agitation/AgitValidationBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\ValidationBundle\Exception;

use Agit\BaseBundle\Exception\AgitException;

/**
 * The validation of a value has failed, see the message field for details.
 */
class InvalidValueException extends AgitException
{
    protected $httpStatus = 400;
}
