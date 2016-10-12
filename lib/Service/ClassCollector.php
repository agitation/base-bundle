<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

use Agit\BaseBundle\Exception\InternalErrorException;
use ReflectionClass;
use Symfony\Component\ClassLoader\ClassMapGenerator;

class ClassCollector
{
    private $resolved = [];

    private $fileCollector;

    public function __construct(FileCollector $fileCollector)
    {
        $this->fileCollector = $fileCollector;
    }

    /**
     * @param string $location something like `FoobarBundle:Directory:Subdir`
     */
    public function collect($location, $skipAbstract = true, $skipTraits = true)
    {
        $files = $this->fileCollector->collect($location, "php");
        $classes = [];

        foreach ($files as $file) {
            $className = $this->getFullClass($file);
            if (! $className || interface_exists($className)) {
                continue;
            }

            if (! class_exists($className) && ! trait_exists($className)) {
                throw new InternalErrorException("Class $className was found, but does not seem to be a valid class.");
            }

            if ($skipAbstract || $skipTraits) {
                $refl = new ReflectionClass($className);

                if ($skipAbstract && $refl->isAbstract() || $skipTraits && $refl->isTrait()) {
                    continue;
                }
            }

            $classes[] = $className;
        }

        return $classes;
    }

    private function getFullClass($file)
    {
        $dir = dirname($file);

        if (! isset($this->resolved[$file])) {
            $this->resolved += array_flip(ClassMapGenerator::createMap($dir));
        }

        return isset($this->resolved[$file]) ? $this->resolved[$file] : "";
    }
}
