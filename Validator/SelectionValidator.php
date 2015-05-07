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

class SelectionValidator extends AbstractValidator
{
    public function validate($value, array $possibleValues = [])
    {
        if (!in_array($value, $possibleValues))
            throw new InvalidValueException(sprintf(
                $this->translate->t("The value must be one of the following: “%s”."),
                implode(
                    $this->translate->x('”, “', 'quotation inside collection'),
                    $possibleValues)
            ));
    }
}