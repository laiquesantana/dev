<?php

namespace dev\Modules\Vendas\Creation\Responses;

use dev\Modules\Vendas\Creation\Presenters\PresenterInterface;
use dev\Modules\Vendas\Creation\Presenters\Responses\ResponsePresenter;
use dev\Modules\Vendas\Generics\Collections\VendasCollection;
use dev\Modules\Vendas\Generics\Entities\Status;

class Response implements ResponseInterface
{

    private Status $status;
    private VendasCollection $data;
    private array $meta;
    private string $error;
    private ResponsePresenter $presenter;

    public function __construct()
    {
        $this->presenter = new ResponsePresenter($this);
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): Response
    {
        $this->status = $status;
        return $this;
    }

    public function getData(): VendasCollection
    {
        return $this->data;
    }

    public function setData(VendasCollection $data): ?Response
    {
        $this->data = $data;
        return $this;
    }

    public function setMeta(array $meta): Response
    {
        $this->meta = $meta;
        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): Response
    {
        $this->error = $error;
        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getPresenter(): PresenterInterface
    {
        return $this->presenter->present();
    }
}
