<?php

namespace App\Repositories;

use App\Entities\AttackEntity;
use App\Entities\LogEntity;
use App\Models\Attack;
use App\Models\Customer;
use App\Models\Project;

class AttackRepository
{
    public function insertOrUpdate(AttackEntity $attackEntity, LogEntity $logEntity, Project $project, Customer $customer): Attack
    {
        $attack = Attack::query()
            ->whereDescription($attackEntity->get('description'))
            ->whereUrl($attackEntity->get('route'))
            ->first();

        if (is_null($attack)) {
            // Notify new attack?
            $attack = Attack::create([
                'description' => $attackEntity->get('description'),
                'url' => $attackEntity->get('route'),
            ]);
        }

        (new LogRepository)->create(
            $logEntity->get('raw_body'),
            $logEntity->get('request'),
            $logEntity->get('server'),
            $logEntity->get('headers'),
            $logEntity->get('trace'),
            $attack,
            $customer,
            $project,
        );

        return $attack;
    }
}
