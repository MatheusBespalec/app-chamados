<?php

namespace App\Http\Controllers;

use App\Models\Attack;
use App\Models\Customer;
use App\Models\Error;
use App\Models\Log;
use App\Models\Project;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $customers = Customer::all();

        $query = Log::query();

        if ($request->id) {
            $query->where('id', 'like', "%{$request->id}%");
        }

        if ($request->project) {
            $query->where('project_id', $request->project);
        }

        if ($request->customer) {
            $query->where('customer_id', $request->customer);
        }

        if ($request->from) {
            $query->where('created_at', '>=', "{$request->from} 00:00:00");
        }

        if ($request->until) {
            $query->where('created_at', '<=', "{$request->until} 23:59:59");
        }

        $logs = $query->with(['customer', 'project'])->orderBy('created_at', 'desc')->paginate(10);
        return inertia('Log/Index', compact('logs', 'projects', 'customers'));
    }

    public function show(Log $log)
    {
        $originRoute = match ($log->logable_type) {
            Error::class => 'errors',
            Attack::class => 'attacks'
        };
        return inertia('Log/Show', compact('log', 'originRoute'));
    }
}
