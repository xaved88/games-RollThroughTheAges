<?php

namespace Jane;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class JaneAutoloader
{
    public function initiateAutoloadRegistry()
    {
        spl_autoload_register([$this, 'autoloadRegistryCallback']);
    }

    /**
     * @return array[]
     */
    public function loadConfigs()
    {
        $files  = $this->findFilesInDirectory(APP_CONFIG_DIR, ['ini']);
        $values = [];
        foreach ($files as $file) {
            $configName = $file->getFilename();
            $configName = substr($configName, 0, -4);

            $file     = file_get_contents($file->getPathname());
            $settings = parse_ini_string($file);
            foreach ($settings as $settingName => $settingValue) {
                $values["config." . $configName . "." . $settingName] = $settingValue;
            }
        }

        return $values;
    }

    /**
     * @param string $class
     */
    private function autoloadRegistryCallback(string $class)
    {
        $pieces = explode('\\', $class);
        $domain = array_shift($pieces);
        if (APP_PROJECT_NAMESPACE === $domain) {
            if ($pieces[0] === APP_FUNCTIONAL_TESTS_NAMESPACE) {
                array_shift($pieces);
                include_once APP_FUNCTIONAL_TESTS_DIR . implode('\\', $pieces) . ".php";
            } elseif ($pieces[0] === APP_SERVICE_NAMESPACE) {
                array_shift($pieces);
                include_once APP_SERVICE_DIR . implode('\\', $pieces) . ".php";
            } else {
                include_once APP_INCLUDES_DIR . implode('\\', $pieces) . ".php";
            }
        } elseif (APP_JANE_NAMESPACE === $domain) {
            include_once APP_JANE_DIR . implode('\\', $pieces) . ".php";
        }
    }

    /**
     * @param string $directory
     * @param array  $fileTypes
     *
     * @return array
     */
    private function findFilesInDirectory(string $directory, array $fileTypes)
    {
        $filesFound        = [];
        $directoryIterator = new RecursiveDirectoryIterator($directory);
        foreach (new RecursiveIteratorIterator($directoryIterator) as $file) {
            $parts     = explode('.', $file);
            $extension = array_pop($parts);
            if (in_array(strtolower($extension), $fileTypes)) {
                $filesFound[] = $file;
            }
        }

        return $filesFound;
    }
}