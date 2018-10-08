<?php

namespace App\Service\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    private $logger;

    /**
     * Logger constructor.
     * @param string $loggerFolder
     * @throws \Exception
     */
    public function __construct(string $loggerFolder)
    {
        $this->logger = new Monolog('api');
        if (!is_dir($loggerFolder)) {
            mkdir($loggerFolder, 0777, true);
        }

        $this->logger->pushHandler(
            new StreamHandler(
                $loggerFolder . '/api.log',
                Monolog::DEBUG
            )
        );
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function emergency($message, array $context = array())
    {
        return $this->logger->emergency($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function alert($message, array $context = array())
    {
        return $this->logger->alert($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function critical($message, array $context = array())
    {
        return $this->logger->critical($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function error($message, array $context = array())
    {
        return $this->logger->error($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function warning($message, array $context = array())
    {
        return $this->logger->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function notice($message, array $context = array())
    {
        return $this->logger->notice($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function info($message, array $context = array())
    {
        return $this->logger->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function debug($message, array $context = array())
    {
        return $this->logger->debug($message, $context);
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function log($level, $message, array $context = array())
    {
        return $this->logger->log($message, $context);
    }
}