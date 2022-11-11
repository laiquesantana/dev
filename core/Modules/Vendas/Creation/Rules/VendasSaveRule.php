<?php

namespace dev\Modules\Vendas\Creation\Rules;

use dev\Modules\Vendas\Creation\Exceptions\SaveVendaException;
use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Vendas;
use dev\Modules\Vendas\Generics\Gateways\VendaGateway;

class VendasSaveRule
{
    private VendaGateway $vendaGateway;
    private VendasCollection $vendasCollection;

    public function __construct(
        VendaGateway $vendaGateway
    ) {
        $this->vendaGateway = $vendaGateway;
    }

    public function __invoke(VendasCollection $vendasCollection): VendasSaveRule
    {
        $this->vendasCollection = $vendasCollection;
        return $this;
    }

    public function apply(): VendasCollection
    {
        try {
            return $this->vendaGateway->save($this->vendasCollection);
        } catch (\Throwable $ex) {
            throw new SaveVendaException('Error ao tentar salvar venda', 500, $ex);
        }
    }
}
