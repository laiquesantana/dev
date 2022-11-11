<?php

namespace dev\Dependencies\Adapters\Logger\Processors;

use Monolog\Processor\ProcessorInterface;

class ContextProcessor implements ProcessorInterface
{
    public function __invoke(array $records)
    {
        if (isset($records['context']) && empty($records['context'])) {
            unset($records['context']);
        }

        return $records;
    }
}
