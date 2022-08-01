<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAttachProjectRequest;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Customer;
use App\Models\CustomerProject;
use App\Models\Project;
use App\Repositories\CustomerRepository;
use App\Repositories\MessageRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()->paginate(10);
        return inertia('Customer/Index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['messages.user']);
        $projects = Project::query()->whereNotIn('id', $customer->projects->modelKeys())->get();
        return inertia('Customer/Show', compact('customer', 'projects'));
    }

    public function create()
    {
        return inertia('Customer/Create');
    }

    public function store(CustomerRepository $repository, CustomerStoreRequest $request)
    {
        $customer = $repository->create($request->name);
        return redirect()->route('customers.show', ['customer' => $customer->id]);
    }

    public function attachProject(Customer $customer, CustomerAttachProjectRequest $request)
    {
        $customer->projects()->attach($request->project_id, ['uuid' => Str::uuid()]);
        return redirect()->back()->with('success', 'Projeto adicionado!');
    }

    public function storeMessage(MessageRepository $repository, Customer $customer, MessageStoreRequest $request)
    {
        $repository->saveInternalMessage($customer, $request?->text, $request?->file);
        return redirect()->back()->with('success', 'Sua mensagem foi salva');
    }
}
