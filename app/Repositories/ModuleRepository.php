<?php

namespace App\Repositories;

use App\Models\Module;
use App\Models\Project;

class ModuleRepository
{
    public function create(string $name, string $description, Project $project): Module
    {
        return $project->modules()->create(compact('name', 'description'));
    }
}
