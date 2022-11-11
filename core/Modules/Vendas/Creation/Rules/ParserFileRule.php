<?php

namespace dev\Modules\Vendas\Creation\Rules;

use dev\Modules\Vendas\Creation\Exceptions\ParserFileException;
use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Vendas;

class ParserFileRule
{
    private Vendas $venda;

    public function __construct(
        Vendas $venda
    ) {
        $this->venda = $venda;
    }

    public function apply(): VendasCollection
    {
        try {
            return $this->parserFile();
        } catch (\Throwable $ex) {
            throw new ParserFileException('Error ao fazer o parser o arquivo', 500, $ex);
        }
    }

    private function parserFile(): VendasCollection
    {
        $txt_file = file_get_contents($this->venda->getArquivo());

        $rows = explode("\n", $txt_file);

        array_shift($rows);

        $vendaCollection = new VendasCollection();
        foreach ($rows as $row => $data) {
            if (!empty($data) && $data != '') {
                $venda = new Vendas();
                $row_data = preg_split("/\t+/", $data);

                $venda->setComprador($row_data[0] ?? null);
                $venda->setDescricao($row_data[1] ?? null);
                $venda->setPrecoUnitario($row_data[2] ?? null);
                $venda->setQuantidade($row_data[3] ?? null);
                $venda->setEndereco($row_data[4] ?? null);
                $venda->setFornecedor($row_data[5] ?? null);

                $vendaCollection->add($venda);
            }
        }

        return $vendaCollection;
    }
}
