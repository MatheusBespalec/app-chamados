<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function create(string $name, array $modules): Project
    {
        $project = Project::create(['name' => $name]);

        $project->modules()->insert(array_map(fn ($module) => [
            'name' => $module['name'],
            'description' => $module['description'],
            'project_id' => $project->id
        ], $modules));

        return $project;
    }
}
