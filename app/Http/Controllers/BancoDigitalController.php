<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class BancoDigitalController extends Controller
{
    private Project $project;

    public function __construct()
    {
        $this->project = Project::query()->where('private_route', 'banco-digital')->first();
    }

    public function index()
    {
        return inertia('Project/BancoDigital/Index', [
            'project' => $this->project,
            'customers' => $this->project->customers()->paginate(10)
        ]);
    }

    public function show(int $customerId)
    {
        $customer = Customer::query()->whereId($customerId)->with('logs')->first();
        return inertia('Project/BancoDigital/Show', [
            'project' => $this->project,
            'customer' => $customer
        ]);
    }

    public function enableIpDebug()
    {

    }

    public function disableVans()
    {

    }
}
