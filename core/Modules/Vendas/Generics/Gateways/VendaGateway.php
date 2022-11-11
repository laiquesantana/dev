<?php

namespace dev\Modules\Vendas\Generics\Gateways;

use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Vendas;

interface VendaGateway
{
    public function save(VendasCollection $vendaEntity): VendasCollection;
}
