<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Agit\BaseBundle\Exception\InternalErrorException;

class UrlService
{
    private $domains = [];

    private $protocol;

    public function __construct($appDomain, $cdnDomain)
    {
        $this->domains = ["app" => $appDomain, "cdn" => $cdnDomain];

        $this->protocol = (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) !== "off")
            ? "https"
            : "http";
    }

    public function getAppDomain()
    {
        return $this->domains["app"];
    }

    public function getCdnDomain()
    {
        return $this->domains["cdn"];
    }

    public function createAppUrl($path = "", array $params = [])
    {
        return $this->createUrl("app", $path, $params);
    }

    public function createCdnUrl($path = "", array $params = [])
    {
        return $this->createUrl("cdn", $path, $params);
    }

    public function createUrl($type, $path = "", array $params = [])
    {
        if (! isset($this->domains[$type])) {
            throw new InternalErrorException("Invalid domain type");
        }

        $url = sprintf("%s://%s/%s", $this->protocol, $this->domains[$type], ltrim($path, "/"));

        if (count($params)) {
            $url = $this->append($url, $params);
        }

        return $url;
    }

    /**
     * append request parameters to a given URL.
     */
    public function append($url, array $params, $enctype = "")
    {
        if ($enctype === "html") {
            $amp = "&amp;";
        } elseif ($enctype === "url") {
            $amp = "%26";
        } else {
            $amp = "&";
        }

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $key     .= "[]";
                $urlpart  = [];

                foreach ($value as $val) {
                    $urlpart[] = "$key=$val";
                }

                $urlpart = implode($amp, $urlpart);
            } else {
                $urlpart = "$key=$value";
            }

            $url .= (strpos($url, "?") ? $amp : "?") . $urlpart;
        }

        return $url;
    }
}
