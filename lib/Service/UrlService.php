<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

class UrlService
{
    public function createAppUrl($path = '', array $params = []) : string
    {
        $url = $this->getUrlBase() ?: '';
        $url .= '/' . trim($path, '/');

        if (count($params))
        {
            $url = $this->append($url, $params);
        }

        return $url;
    }

    public function getAppDomain() : string
    {
        return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
    }

    public function getUrlBase() : ?string
    {
        $url = null;
        $port = (int)$_SERVER['SERVER_PORT'];

        if ($port)
        {
            $ssl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'));

            $url = ($ssl ? 'https' : 'http') . '://' . $this->getAppDomain();
            $url .= ($ssl && $port === 443 || !$ssl && $port === 80) ? '' : ":$port";
        }

        return $url;
    }

    /**
     * append request parameters to a given URL.
     * @param mixed $url
     * @param mixed $enctype
     */
    public function append($url, array $params, $enctype = '')
    {
        if ($enctype === 'html')
        {
            $amp = '&amp;';
        }
        elseif ($enctype === 'url')
        {
            $amp = '%26';
        }
        else
        {
            $amp = '&';
        }

        foreach ($params as $key => $value)
        {
            if (is_array($value))
            {
                $key .= '[]';
                $urlpart = [];

                foreach ($value as $val)
                {
                    $urlpart[] = "$key=$val";
                }

                $urlpart = implode($amp, $urlpart);
            }
            else
            {
                $urlpart = "$key=$value";
            }

            $url .= (strpos($url, '?') ? $amp : '?') . $urlpart;
        }

        return $url;
    }
}
