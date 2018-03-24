<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Exception;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * NOTE: When extending this class, remember to set an appropriate status code.
 */
abstract class PublicException extends RuntimeException implements HttpExceptionInterface
{
    protected $statusCode = 500;

    /**
     * Returns an HTTP status which indicates the type of error.
     *
     * @return int the numeric HTTP status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return [];
    }
}
