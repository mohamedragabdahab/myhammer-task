<?php

namespace App\Builder;

use App\Entity\EntityInterface;
use App\Entity\Service as EntityService;

class Service implements BuilderInterface
{
    public static function build(array $parameters): EntityInterface
    {
        $attributes = [];
        $attributes['id'] = $parameters['id'] ?? null;
        $attributes['name'] = $parameters['name'] ?? null;

        return new EntityService($attributes['id'], $attributes['name']);
    }
}
