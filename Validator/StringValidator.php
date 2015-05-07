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

class StringValidator extends AbstractValidator
{
    public function validate($value, $minLength=null, $maxLength=null, $noCtl=false)
    {
        if (!is_string($value))
            throw new InvalidValueException($this->translate->t("The value must be a string."));

        if (is_int($minLength) && strlen($value) < $minLength)
            throw new InvalidValueException(sprintf($this->translate->t("The value is too short, it must have at least %s characters."), $minLength));

        if (is_int($maxLength) && strlen($value) > $maxLength)
            throw new InvalidValueException(sprintf($this->translate->t("The value is too long, it must have at most %s characters."), $maxLength));

        // filtering for control characters, but maybe allow \n, \r and \t
        $allowedCntrlChars = $noCtl ? [] : [9, 10, 13];

        if (preg_match_all('/[[:cntrl:]]/', $value, $matches))
        {
            foreach ($matches[0] as $match)
            {
                if (!in_array(ord($match), $allowedCntrlChars))
                {
                    throw new InvalidValueException($this->translate->t("The value contains invalid characters."));
                }
            }
        }
    }
}