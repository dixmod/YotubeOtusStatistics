<?php

namespace App\Service;

class Config
{
    /** @var array */
    private static $_config;

    /** @var Config */
    private static $_instance;

    /**
     * @param bool $key
     * @return array|mixed
     */
    public static function getOptions($key = false)
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
        if (empty(self::$_config)) {
            self::$_config = $this->getContentFileConfig();
        }
    }

    /**
     * @return string
     */
    private function getPathToConfig(): string
    {
        return
            $this->getProjectRoot()
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'config.php';
    }

    /**
     * @return string
     */
    private function getProjectRoot(): string
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
    private function getContentFileConfig(): array
    {
        $pathToFileConfig = $this->getPathToConfig();
        return is_file($pathToFileConfig)
            ? include $pathToFileConfig
            : [];
    }
}