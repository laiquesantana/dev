<?php

namespace dev\Modules\Vendas\Creation\Presenters\Responses;

use dev\Modules\Vendas\Creation\Presenters\PresenterInterface;
use dev\Modules\Vendas\Creation\Responses\Response;

class ResponsePresenter implements PresenterInterface
{
    private Response $response;
    private array $presenter;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function present(): PresenterInterface
    {
        $this->presenter = [
            'status' => [
                'code' => $this->response->getStatus()->getCode(),
                'message' => $this->response->getStatus()->getMessage(),
            ],
            'data' => ($this->response->getData()),
            'meta' => $this->response->getMeta()
        ];

        return $this;
    }

    public function toArray(): array
    {
        foreach ($this->presenter['data']->all() as $item) {
            $venda = [
                'comprador' => $item->getComprador(),
                'fornecedor' => $item->getFornecedor(),
                'descricao' => $item->getDescricao(),
                'preco_unitario' => $item->getPrecoUnitario(),
                'quantidade' => $item->getQuantidade(),
                'endereco' => $item->getEndereco(),
            ];
            $vendas[] = $venda;
        }
        $this->presenter['data'] = $vendas;
        return $this->presenter;
    }
}
