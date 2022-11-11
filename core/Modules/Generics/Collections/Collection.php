<?php

declare(strict_types=1);

namespace dev\Modules\Generics\Collections;

use dev\Modules\Generics\Entities\EntityInterface;
use dev\Modules\Generics\Exceptions\MethodNotFoundException;

class Collection
{
    protected array $collector = [];

    public function all(): array
    {
        return $this->collector;
    }

    public function isEmpty(): bool
    {
        return count($this->collector) === 0;
    }

    public function size(): int
    {
        return count($this->collector);
    }

    public function pluck(string $property): array
    {
        $method = 'get' . str_replace('_', '', ucwords($property, '_'));

        return array_values(
            array_map(
                function (EntityInterface $entity) use ($method) {
                    if (!method_exists($entity, $method)) {
                        throw (new MethodNotFoundException($method));
                    }
                    return $entity->$method();
                },
                $this->collector
            )
        );
    }
}
