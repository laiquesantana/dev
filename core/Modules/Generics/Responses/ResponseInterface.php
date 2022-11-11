<?php

namespace dev\Modules\Generics\Responses;

use dev\Modules\Generics\Entities\Status;

interface ResponseInterface
{
    public function getStatus(): Status;
}
