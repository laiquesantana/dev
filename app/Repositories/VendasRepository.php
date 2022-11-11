<?php

namespace App\Repositories;

use App\Models\FormularioVendas;
use dev\Modules\Generics\Exceptions\DatabaseException;
use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Vendas;
use dev\Modules\Vendas\Generics\Gateways\VendaGateway;

class VendasRepository implements VendaGateway
{
    public function retornaTodasVendas()
    {
        return FormularioVendas::all();
    }

    public function deletarVenda(int $idVenda)
    {
        try {
            return FormularioVendas::findOrFail($idVenda)->delete();
        } catch (\Throwable $exception) {
            throw new DatabaseException("Problema ao deletar venda");
        }
    }

    public function save(VendasCollection $vendasCollection): VendasCollection
    {
        try {
            foreach ($vendasCollection->all() as $venda) {
                FormularioVendas::create(
                    [
                        'comprador' => $venda->getComprador(),
                        'descricao' => $venda->getDescricao(),
                        'fornecedor' => $venda->getFornecedor(),
                        'quantidade' => $venda->getQuantidade(),
                        'preco_unitario' => $venda->getPrecoUnitario(),
                        'endereco' => $venda->getEndereco(),
                    ],
                );
            }
        } catch (\Throwable) {
            new DatabaseException("Error ao tentar salvar a venda");
        }

        return $vendasCollection;
    }
}
