<?php

namespace dev\Modules\Vendas\Creation\Exceptions;

use Exception;
use Throwable;

class ParserFileException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
