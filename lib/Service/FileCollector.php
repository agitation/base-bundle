<?php
declare(strict_types=1);
/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel;

class FileCollector
{
    private $kernel;

    private $namespaces;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param string $location, namespace or something like `FoobarBundle:Directory:Subdir`
     */
    public function resolve($location)
    {
        $path = null;

        try
        {
            if (strpos($location, '\\') !== false)
            {
                $location = trim($location, '\\');

                foreach ($this->getNamespaces() as $name => $namespace)
                {
                    if (strpos($location, $namespace) === 0)
                    {
                        $location = str_replace($namespace, $name, $location);
                        $location = str_replace('\\', '/', "@$location");
                        $path = $this->kernel->locateResource($location);

                        break;
                    }
                }
            }
            else
            {
                // assuming a namespace alias in colon notation, or just a bundle name

                if ($location[0] !== '@')
                {
                    $location = "@$location";
                }

                $path = $this->kernel->locateResource(str_replace(':', '/', $location));
            }
        }
        catch (\Exception $e)
        {
        }

        return $path;
    }

    /**
     * @param string $location,  something like `FoobarBundle:Directory:Subdir`
     * @param string $extension, something like `php` or `html.twig`
     */
    public function collect($location, $extension)
    {
        $path = $location[0] === '/' ? $location : $this->resolve($location);
        $files = [];

        if ($path)
        {
            $finder = new Finder();
            $finder->in($path)->name("*.$extension");

            foreach ($finder as $file)
            {
                $files[] = $file->getRealpath();
            }
        }

        return $files;
    }

    private function getNamespaces()
    {
        if ($this->namespaces === null)
        {
            $this->namespaces = [];

            foreach ($this->kernel->getBundles() as $name => $bundle)
            {
                $this->namespaces[$name] = $bundle->getNamespace();
            }
        }

        return $this->namespaces;
    }
}
