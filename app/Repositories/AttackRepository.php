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
            ->whereUrl($attackEntity->get('url'))
            ->first();

        if (is_null($attack)) {
            // Notify new error?
            $attack = Attack::create([
                'description' => $attackEntity->get('description'),
                'url' => $attackEntity->get('url'),
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
