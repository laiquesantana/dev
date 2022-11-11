<?php

namespace dev\Modules\Vendas\Generics\Collections;

use dev\Modules\Generics\Collections\Collection;
use dev\Modules\Vendas\Generics\Entities\Vendas;

class VendasCollection extends Collection
{
    public function add(Vendas $venda): VendasCollection
    {
        $this->collector[] = $venda;
        return $this;
    }

    public function merge(VendasCollection $vendaCollection): void
    {
        $this->collector = array_merge($this->collector, $vendaCollection->all());
    }
}
