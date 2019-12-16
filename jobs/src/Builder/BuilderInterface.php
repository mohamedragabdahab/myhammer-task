<?php

namespace App\Builder;

use App\Entity\EntityInterface;

interface BuilderInterface
{
    public static function build(array $params): EntityInterface;
}
