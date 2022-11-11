<?php

namespace dev\Dependencies\Adapters\Logger\Processors;

use Monolog\Processor\ProcessorInterface;

class DatetimeProcessor implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        $record['datetime'] = $record['datetime']->format('c');

        return $record;
    }
}
