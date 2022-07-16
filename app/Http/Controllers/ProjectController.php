<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Customer;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()->withCount(['modules', 'customers'])->paginate(10);
        return inertia('Project/Index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load('modules');
        $customers = $project->customers()->paginate(10);
        return inertia('Project/Show', compact('project', 'customers'));
    }

    public function create()
    {
        return inertia('Project/Create');
    }

    public function edit(Project $project)
    {
        return inertia('Project/Edit', compact('project'));
    }

    public function store(ProjectRepository $repository, ProjectStoreRequest $request)
    {
        $project = $repository->create($request->name, $request->modules);
        return redirect()->route('projects.show', ['project' => $project->id]);
    }
}
