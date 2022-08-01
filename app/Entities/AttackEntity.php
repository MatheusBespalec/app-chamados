<?php

namespace App\Entities;

use Illuminate\Support\Facades\Validator;

class AttackEntity extends Entity
{
    public function __construct(array $errorData)
    {
        Validator::make($errorData, [
            'url' => ['required', 'integer'],
            'description' => ['required', 'string'],
        ])->validate();

        $this->data = $errorData;
    }
}
