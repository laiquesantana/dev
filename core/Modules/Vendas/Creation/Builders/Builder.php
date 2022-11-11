<?php

namespace dev\Modules\Vendas\Creation\Builders;

use dev\Modules\Vendas\Creation\Rules\ParserFileRule;
use dev\Modules\Vendas\Generics\Entities\Status;
use dev\Modules\Vendas\Creation\Rules\VendasSaveRule;
use dev\Modules\Vendas\Creation\Responses\Response;

class Builder
{
    private VendasSaveRule $vendasSaveRule;
    private ParserFileRule $parserFileRule;

    public function withParserFileRule(ParserFileRule $parserFileRule): Builder
    {
        $this->parserFileRule = $parserFileRule;
        return $this;
    }

    public function withVendasSaveRule(VendasSaveRule $vendasSaveRule): Builder
    {
        $this->vendasSaveRule = $vendasSaveRule;
        return $this;
    }

    public function build(): Response
    {
        $vendasCollection = $this->parserFileRule->apply();
        $vendas = ($this->vendasSaveRule)($vendasCollection)->apply();

        return
            (new Response())
                ->setStatus(
                    (new Status())
                        ->setCode(201)
                        ->setMessage('Venda criada com sucesso')
                )
                ->setData($vendas)
                ->setMeta([
                    'total' => $vendas->size(),
                ]);
    }
}
