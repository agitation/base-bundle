<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Exception;

/**
 * The mother of all Agitation exceptions.
 *
 * NOTE: When extending this class, remember to set an appropriate status code.
 */
abstract class AgitException extends \Exception
{
    protected $httpStatus = 500;

    /**
     * Returns an HTTP status which indicates the type of error.
     *
     * @return int the numeric HTTP status code.
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }
}
