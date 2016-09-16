<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Exception;

/**
 * We've messed something up internally, and now a certain process cannot
 * continue.
 */
class InternalErrorException extends AgitException
{
    protected $httpStatus = 500;
}
