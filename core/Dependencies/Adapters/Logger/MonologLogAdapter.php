<?php

namespace dev\Dependencies\Adapters\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use dev\Dependencies\Adapters\Logger\Processors\ContextProcessor;
use dev\Dependencies\Adapters\Logger\Processors\DatetimeProcessor;
use dev\Dependencies\Interfaces\LogInterface;

class MonologLogAdapter implements LogInterface
{
    private Logger $log;

    public function __construct()
    {
        $handler = new StreamHandler("php://stdout");
        $handler->setFormatter(new JsonFormatter());
        $this->log = (new Logger('test_dev_logger'))
            ->pushHandler($handler)
            ->pushProcessor(new DatetimeProcessor())
            ->pushProcessor(new ContextProcessor());
    }

    public function alert(string $message, array $context = []): bool
    {
        $this->log->alert($message, $context);
        return true;
    }

    public function debug(string $message, array $context = []): bool
    {
        $this->log->debug($message, $context);
        return true;
    }

    public function emergency(string $message, array $context = []): bool
    {
        $this->log->emergency($message, $context);
        return true;
    }

    public function error(string $message, array $context = []): bool
    {
        $this->log->error($message, $context);
        return true;
    }

    public function info(string $message, array $context = []): bool
    {
        $this->log->info($message, $context);
        return true;
    }

    public function notice(string $message, array $context = []): bool
    {
        $this->log->notice($message, $context);
        return true;
    }

    public function warning(string $message, array $context = []): bool
    {
        $this->log->warning($message, $context);
        return true;
    }
}
