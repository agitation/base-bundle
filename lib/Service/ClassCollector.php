<?php

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Service;

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
    public function collect($location)
    {
        $files = $this->fileCollector->collect($location, "php");
        $classes = [];

        foreach ($files as $file) {
            $className = $this->getFullClass($file);
            if (! $className) {
                continue;
            }

            $classExists = class_exists($className);

            if ($classExists) {
                $refl = new \ReflectionClass($className);
                if ($refl->isAbstract()) {
                    continue;
                }

                $classes[] = $className;
            }
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
