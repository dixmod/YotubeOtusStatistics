<?php

namespace Dixmod\Services;

class Config
{
    private static $_config;
    private static $_instance;

    /**
     * @param bool $key
     * @return array|mixed
     */
    public static function getOptions($key=false)
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        if (empty($key)) {
            return self::$_config;
        }

        if (isset(self::$_config[$key])) {
            return self::$_config[$key];
        } else {
            return [];
        }
    }

    /**
     * Config constructor.
     */
    private function __construct()
    {
        if (!isset(self::$_config)) {
            self::$_config = $this->getContentFileConfig();
        }
    }

    /**
     * @return string
     */
    private function getPathToConfig()
    {
        return
            $this->getProjectRoot()
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'config.php';
    }

    /**
     * @return string
     */
    private function getProjectRoot()
    {
        return realpath(
            empty($_SERVER['DOCUMENT_ROOT'])
                ? getcwd()
                : $_SERVER['DOCUMENT_ROOT']
        );
    }

    /**
     * @return array|mixed
     */
    private function getContentFileConfig()
    {
        $pathToFileConfig = $this->getPathToConfig();
        return is_file($pathToFileConfig)
            ? include_once $pathToFileConfig
            : [];
    }
}