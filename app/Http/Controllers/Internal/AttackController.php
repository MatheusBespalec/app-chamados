<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttackRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Attack;
use App\Models\Customer;
use App\Models\Log;
use App\Repositories\AttackRepository;
use App\Repositories\MessageRepository;
use App\Repositories\NoteRepository;
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
            $query->where('until', '<=', "%{$request->until}% 23:59:59");
        }

        $attacks = $query->paginate(10);
        return inertia('Attack/Index', compact('attacks'));
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
