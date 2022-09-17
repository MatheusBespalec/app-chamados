<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function create(string $name, ?string $privateRoute): Project
    {
        $project = Project::create(['name' => $name, 'private_route' => $privateRoute]);
        return $project;
    }
}
