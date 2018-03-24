<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Exception;

/**
 * The parameters passed for creating or modifying an entity are invalid.
 */
class InvalidEntityFieldException extends PublicException
{
    protected $statusCode = 400;
}
