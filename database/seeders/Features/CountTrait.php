<?php

namespace Database\Seeders\Features;

trait CountTrait
{
    public function isCount(string $className): bool
    {
        return (bool)$className::count();
    }
}
