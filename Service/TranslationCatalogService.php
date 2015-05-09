<?php
/**
 * @package    agitation/intl
 * @link       http://github.com/agitation/AgitIntlBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\IntlBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Agit\CoreBundle\Exception\InternalErrorException;
use Agit\CoreBundle\Service\FileCollector;
use Agit\IntlBundle\Event\TranslationFilesRegistrationEvent;
use Agit\IntlBundle\Event\CatalogFinishedEvent;

/*
    test:
        collect strings from PHP files
        collect strings from JS files
        merge catalogs, existing with new strings
        merge catalogs, new catalog with new strings
        merge catalogs with duplicate strings
        msgfmt and parse statistics
*/

class TranslationCatalogService
{
    protected $GettextService;

    protected $FileCollector;

    protected $EventDispatcher;

    protected $locales;

    protected $fileTypes;

    protected $globalCatalogPath;

    protected $keywords = ['t', 'x:2c,1', 'n:1,2', 'ts:1', 'noop'];

    // where we expect a bundle's translation files, relative to the bundle's base path
    protected $bundleCatalogSubdir;

    protected $catalogName = 'agit';

    protected $eventRegistrationTag = 'agit.intl.catalog';

    // lists of files added through event listeners
    protected $extraFileList = [];

    public function __construct(GettextService $GettextService, FileCollector $FileCollector, EventDispatcher $EventDispatcher, array $locales, array $fileTypes, $globalCatalogPath, $bundleCatalogSubdir)
    {
        $this->GettextService = $GettextService;
        $this->FileCollector = $FileCollector;
        $this->EventDispatcher = $EventDispatcher;
        $this->locales = $locales;
        $this->fileTypes = $fileTypes;
        $this->globalCatalogPath = $globalCatalogPath;
        $this->bundleCatalogSubdir = $bundleCatalogSubdir;
        $this->Filesystem = new Filesystem();
    }

    /**
     * @param $bundleAlias a bundle alias
     */
    public function generateBundleCatalog($bundleAlias)
    {
        $bundlePath = $this->FileCollector->resolve($bundleAlias);
        $bundleCatalogPath = "$bundlePath{$this->bundleCatalogSubdir}";
        $fileList = [];
        $foundMessages = [];

        $this->EventDispatcher->dispatch(
            "{$this->eventRegistrationTag}.files",
            new TranslationFilesRegistrationEvent($this, $bundleAlias));

        foreach ($this->fileTypes as $ext => $progLang)
        {
            $langFileList = [];
            $Finder = (new Finder())->in($bundlePath)->notPath('/Test.*/')->notPath('/external/')->name("*\.$ext");

            foreach ($Finder as $File)
            {
                $filePath = $File->getRealpath();
                $fileRelPath = str_replace($bundlePath, '', $filePath);
                $langFileList[$fileRelPath] = $filePath;
            }

            if (isset($this->extraFileList[$progLang]))
                $langFileList += $this->extraFileList[$progLang];

            $fileList += $langFileList;
            $foundMessages[] = $this->GettextService->xgettext($langFileList, $progLang, $this->keywords);
        }

        foreach ($this->locales as $locale)
        {
            $filename = "bundle.$locale.po";
            $filepath = "$bundleCatalogPath/$filename";
            $localeHeader = $this->GettextService->createCatalogHeader($locale);
            $localeFoundMessages = $localeHeader . implode("\n\n", $foundMessages);

            // filter all NEW messages
            $localeFoundMessages = $this->GettextService->msguniq($localeFoundMessages);

            $catalog = $this->Filesystem->exists($filepath)
                ? file_get_contents($filepath)
                : $localeHeader;

            $catalog = $this->GettextService->msgmerge($catalog, $localeFoundMessages);

            if ($this->GettextService->countMessages($catalog))
            {
                $replacements = [];

                array_walk($fileList, function($path, $id) use ($bundleAlias, &$replacements) {
                    $replacements["#: $path"] = "#: @$bundleAlias/$id";
                });

                $catalog = str_replace(array_keys($replacements), array_values($replacements), $catalog);

                $this->checkCatalogFileAndCreateIfNeccessary($filepath, $locale);
                $this->Filesystem->dumpFile($filepath, $catalog);
            }
        }

        // give extensions a chance to cleanup
        $this->EventDispatcher->dispatch(
            "{$this->eventRegistrationTag}.finish",
            new CatalogFinishedEvent($bundleAlias));
    }

    public function registerCatalogFiles($progLang, array $fileList)
    {
        if (!isset($this->extraFileList[$progLang]))
            $this->extraFileList[$progLang] = $fileList;
        else
            $this->extraFileList[$progLang] = array_merge($this->extraFileList[$progLang], $fileList);
    }

    /**
     * @param $bundleAliasList a list of bundle aliases
     */
    public function generateGlobalCatalog(array $bundleAliasList)
    {
        $poFiles = [];
        $catalogPath = "{$this->globalCatalogPath}/%s/LC_MESSAGES";

        foreach ($bundleAliasList as $path)
        {
            $bundlePath = $this->FileCollector->resolve($path);
            $bundleCatalogPath = "$bundlePath/{$this->bundleCatalogSubdir}";

            // we ignore bundles that don't "participate"
            if (!is_dir($bundleCatalogPath)) continue;

            $Finder = (new Finder())->in($bundleCatalogPath)->name("*\.po");

            foreach ($Finder as $File)
                $poFiles[] = $File->getRealpath();
        }

        foreach ($this->locales as $locale)
        {
            $locCatalogDirPath = sprintf($catalogPath, $locale);
            $locCatalogFilePath = "$locCatalogDirPath/{$this->catalogName}.po";
            $locMachineFilePath = "$locCatalogDirPath/{$this->catalogName}.mo";

            $localeHeader = $this->GettextService->createCatalogHeader($locale);
            $currentCatalog = $this->Filesystem->exists($locCatalogFilePath)
                ? file_get_contents($locCatalogFilePath)
                : $localeHeader;

            $bundleTranslations = $localeHeader;

            foreach ($poFiles as $poFile)
                if (strpos($poFile, ".$locale.") !== false)
                    $bundleTranslations .= $this->GettextService->removeHeaders(file_get_contents($poFile));

            $bundleTranslations = $this->GettextService->removeHeaders($bundleTranslations);
            $catalog = $this->GettextService->msguniq($currentCatalog, $bundleTranslations);

            if ($this->GettextService->countMessages($catalog))
            {
                $this->checkDirectoryAndCreateIfNeccessary($locCatalogDirPath);
                $this->checkCatalogFileAndCreateIfNeccessary($locCatalogFilePath, $locale);

                $machine = $this->GettextService->msgfmt($catalog, $stats);
                $this->Filesystem->dumpFile($locCatalogFilePath, $catalog);
                $this->Filesystem->dumpFile($locMachineFilePath, $machine);
            }
        }
    }

    protected function checkDirectoryAndCreateIfNeccessary($path)
    {
        clearstatcache(true);

        if (!$this->Filesystem->exists($path))
            $this->Filesystem->mkdir($path, 0744);
        elseif (!is_dir($path) || !is_writable($path))
            throw new InternalErrorException("The path '$path' is not a directory or not writable.");
    }

    protected function checkCatalogFileAndCreateIfNeccessary($path, $locale)
    {
        clearstatcache(true);

        if (!$this->Filesystem->exists($path))
            $this->Filesystem->dumpFile($path, $this->GettextService->createCatalogHeader($locale));
        elseif (!is_file($path) || !is_writable($path))
            throw new InternalErrorException("The file '$path' does not exist or is not writable.");
    }
}