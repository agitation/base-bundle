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

class ScalarValidator extends AbstractValidator
{
    public function validate($value)
    {
        if (!is_scalar($value))
            throw new InvalidValueException($this->translate->t("The value must be scalar."));
    }
}