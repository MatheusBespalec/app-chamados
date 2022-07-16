<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttackRequest;
use App\Models\Attack;
use App\Models\Customer;
use App\Models\Log;
use App\Repositories\AttackRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    /**
     * Displays a list of App\Models\Attack
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $attacks = Attack::query()->paginate(10);
        return inertia('Attack/Index', compact('attacks'));
    }

    /**
     * Display information of a specific App\Models\Attack
     *
     * @param Attack $attack
     * @return \Inertia\Response
     */
    public function show(Attack $attack)
    {
        $logs = Log::query()->orderBy('created_at', 'desc')->whereMorphedTo('logable', $attack)->with('customer', 'notes.user')->paginate(10);
        return inertia('Attack/Show', compact('attack', 'logs'));
    }

    /**
     * Display information of a specific App\Models\Log of App\Models\Attack
     *
     * @param Attack $attack
     * @return \Inertia\Response
     */
    public function log(Log $log)
    {
        $log->load('logable');
        $log->load('customer');

        return inertia('Attack/Log', compact('log'));
    }

    /**
     * Create a new Attack, or updatte if already exists this attack and create a new attack log
     *
     * @param AttackRequest $request
     * @param AttackRepository $attackRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AttackRequest $request, AttackRepository $attackRepository)
    {
        $attackRepository->create(
            $request->description,
            $request->controller,
            $request->action,
            $request->url,
            $request->request_data,
            Customer::query()->whereUuid($request->customer_uuid)
        );

        return response()->json(status: 204);
    }

    public function addNote(NoteRepository $repository, Attack $attack, Request $request)
    {
        $repository->create($request->message, $attack);
        return redirect()->back();
    }
}
