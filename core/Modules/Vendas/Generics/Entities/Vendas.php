<?php

namespace dev\Modules\Vendas\Generics\Entities;

class Vendas
{
    private string $arquivo;
    private string $comprador;
    private string $descricao;
    private string $endereco;
    private string $fornecedor;
    private float $quantidade;

    /**
     * @param string $arquivo
     */
    public function setArquivo(string $arquivo): Vendas
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * @return string
     */
    public function getArquivo(): string
    {
        return $this->arquivo;
    }

    /**
     * @return string
     */
    public function getComprador(): string
    {
        return $this->comprador;
    }

    /**
     * @param string $comprador
     */
    public function setComprador(string $comprador): Vendas
    {
        $this->comprador = $comprador;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao(string $descricao): Vendas
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndereco(): string
    {
        return $this->endereco;
    }

    /**
     * @param string $endereco
     */
    public function setEndereco(string $endereco): Vendas
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * @return string
     */
    public function getFornecedor(): string
    {
        return $this->fornecedor;
    }

    /**
     * @param string $fornecedor
     */
    public function setFornecedor(string $fornecedor): Vendas
    {
        $this->fornecedor = $fornecedor;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantidade(): float
    {
        return $this->quantidade;
    }

    /**
     * @param float $quantidade
     */
    public function setQuantidade(float $quantidade): Vendas
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrecoUnitario(): float
    {
        return $this->preco_unitario;
    }

    /**
     * @param float $preco_unitario
     */
    public function setPrecoUnitario(float $preco_unitario): Vendas
    {
        $this->preco_unitario = $preco_unitario;
        return $this;
    }

    private float $preco_unitario;
}
