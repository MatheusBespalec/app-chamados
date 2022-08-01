<?php

namespace App\Entities;

abstract class Entity
{
    protected array $data;

    public function get(string $varName): mixed
    {
        return $this->data[$varName] ?? null;
    }
}
