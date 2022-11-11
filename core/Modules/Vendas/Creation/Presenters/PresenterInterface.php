<?php

namespace dev\Modules\Vendas\Creation\Presenters;

interface PresenterInterface
{
    public function present(): PresenterInterface;

    public function toArray(): array;
}
