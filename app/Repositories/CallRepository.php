<?php

namespace App\Repositories;

use App\Models\Call;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Support\Str;

class CallRepository
{
    public function create(string $title, string $description, string $from, string $category, Customer $customer, Project $project): Call
    {
        $call = Call::create([
            'title' => $title,
            'uuid' => Str::uuid(),
            'description' => $description,
            'from' => $from,
            'category' => $category,
            'customer_id' => $customer->id,
            'project_id' => $project->id,
        ]);

        return $call;
    }
}
