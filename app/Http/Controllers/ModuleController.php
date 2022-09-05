<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleStoreRequest;
use App\Models\Project;
use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function store(ModuleRepository $repository, ModuleStoreRequest $request)
    {
        $project = Project::find($request->project_id);
        $repository->create($request->name, $request->description, $project);
        return redirect()->route('projects.show', ['project' => $project->id]);
    }
}
