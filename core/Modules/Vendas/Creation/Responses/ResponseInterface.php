<?php

namespace dev\Modules\Vendas\Creation\Responses;

use dev\Modules\Vendas\Creation\Presenters\PresenterInterface;
use dev\Modules\Vendas\Generics\Entities\Status;

interface ResponseInterface
{
    public function getPresenter(): PresenterInterface;

    public function getStatus(): Status;
}
