<?php
/**
 * @package    agitation/validation
 * @link       http://github.com/agitation/AgitValidationBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\ValidationBundle\Validator;

use Agit\ValidationBundle\Exception\InvalidValueException;

class NumericValidator extends AbstractValidator
{
    public function validate($value, $positiveInt=true)
    {
        if (!is_numeric($value))
            throw new InvalidValueException($this->translate->t("The value must be numeric."));

        if ($positiveInt === true && preg_match('|[^\d]|', $value))
            throw new InvalidValueException($this->translate->t("The value must be a positive integer number."));
    }
}