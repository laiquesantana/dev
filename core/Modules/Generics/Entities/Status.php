<?php

namespace dev\Modules\Generics\Entities;

class Status
{
    private int $code;

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): Status
    {
        $this->code = $code;
        return $this;
    }
}
