<?php

namespace App\Entities;

use Illuminate\Support\Facades\Validator;

class AttackEntity extends Entity
{
    public function __construct(array $attackData)
    {
        Validator::make($attackData, [
            'route' => ['required', 'string'],
            'description' => ['required', 'string'],
        ])->validate();

        $this->data = [
            'route' => $attackData['route'],
            'description' => $attackData['description'],
        ];
    }
}
