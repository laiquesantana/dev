<?php

namespace dev\Modules\Generics\Exceptions;

use Exception;
use Throwable;

class DatabaseException extends Exception
{
    public function __construct(
        string $message,
        Throwable $previous = null,
        int $code = 0
    ) {
        parent::__construct($message, $code, $previous);
    }
}
