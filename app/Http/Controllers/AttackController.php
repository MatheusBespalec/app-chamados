<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Attack;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Project;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class AttackController extends Controller
{
    /**
     * Displays a list of App\Models\Attack
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        $customers = Customer::all();
        $query = Attack::query();

        if ($request->id) {
            $query->where('id', 'like', "%{$request->id}%");
        }

        if ($request->url) {
            $query->where('url', 'like', "%{$request->url}%");
        }

        if ($request->from) {
            $query->where('updated_at', '>=', "{$request->from} 00:00:00");
        }

        if ($request->until) {
            $query->where('updated_at', '<=', "{$request->until} 23:59:59");
        }

        $attacks = $query->paginate(10);
        return inertia('Attack/Index', compact('attacks', 'customers', 'projects'));
    }

    /**
     * Display information of a specific App\Models\Attack
     *
     * @param Attack $attack
     * @return \Inertia\Response
     */
    public function show(int $id)
    {
        $attack = Attack::query()->whereId($id)->with('messages.user')->first();
        $logs = Log::query()->orderBy('created_at', 'desc')->whereMorphedTo('logable', $attack)->with('customer')->paginate(10);
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

    public function storeMessage(MessageRepository $repository, Attack $attack, MessageStoreRequest $request)
    {
        $repository->saveInternalMessage($attack, $request?->text, $request?->file);
        return redirect()->back()->with('success', 'Sua mensagem foi salva!');
    }
}
