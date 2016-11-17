<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Exception;

/**
 * The validation of a value has failed, see the message field for details.
 */
class InvalidValueException extends AgitException
{
    protected $statusCode = 400;
}
