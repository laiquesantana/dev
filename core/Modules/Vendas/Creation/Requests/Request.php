<?php

namespace dev\Modules\Vendas\Creation\Requests;

use dev\Modules\Vendas\Generics\Entities\Vendas;

class Request
{
    private Vendas $venda;

    public function __construct(Vendas $venda)
    {
        $this->venda = $venda;
    }

    public function getVenda(): Vendas
    {
        return $this->venda;
    }
}
