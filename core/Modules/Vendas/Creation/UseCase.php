<?php

namespace dev\Modules\Vendas\Creation;

use dev\Dependencies\Interfaces\LogInterface;
use dev\Modules\Vendas\Creation\Builders\Builder;
use dev\Modules\Vendas\Creation\Requests\Request;
use dev\Modules\Vendas\Creation\Responses\ResponseInterface;
use dev\Modules\Vendas\Creation\Rules\ParserFileRule;
use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Status;
use dev\Modules\Vendas\Generics\Gateways\VendaGateway;
use dev\Modules\Vendas\Creation\Responses\Response;
use dev\Modules\Vendas\Creation\Rules\VendasSaveRule;

class UseCase
{
    private VendaGateway $vendaGateway;
    private ResponseInterface $response;
    private const LOG_PREFIX = '[User/Creation::UseCase] ';
    private LogInterface $logger;

    public function __construct(
        VendaGateway $vendaGateway,
        LogInterface $logger

    ) {
        $this->vendaGateway = $vendaGateway;
        $this->logger = $logger;
    }

    public function execute(Request $request): void
    {
        try {
            $this->response = (new Builder())
                ->withParserFileRule(
                    new ParserFileRule($request->getVenda())
                )
                ->withVendasSaveRule(
                    new VendasSaveRule($this->vendaGateway, $request->getVenda())
                )
                ->build();

        }catch (\Throwable $exception) {
            $this->logger->error(
                self::LOG_PREFIX . 'Generic error',
                [
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'previous' => [
                        'exception' => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
                        'message' => $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null
                    ],
                    'data' => [
                        'user' => $request->getVenda(),
                    ]
                ]
            );

            $this->response = (new Response())
                ->setStatus(
                    (new Status())
                        ->setCode($exception->getCode())
                        ->setMessage('Error genérico ao tentar salvar uma venda')
                )
                ->setData(new VendasCollection())
                ->setError("Generic Error")
                ->setMeta(
                    [
                        'total' => 1
                    ]
                );
        }
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
