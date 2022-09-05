<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Call;
use App\Repositories\CallRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CallController extends Controller
{
    public function index()
    {
        $calls = Call::query()->with(['project', 'customer'])->paginate(10);
        return Inertia::render('Call/Index', compact('calls'));
    }

    public function show(int $id)
    {
        $call = Call::query()
            ->whereId($id)
            ->with('customer', 'project')
            ->with(['messages' => function ($query) {
                $query->whereExternal(false)->with('user');
            }])
            ->first();
        return Inertia::render('Call/Show', compact('call'));
    }

    public function history(int $id)
    {
        $call = Call::query()
            ->whereId($id)
            ->with(['messages' => function ($query) {
                $query->whereExternal(true)->with('user');
            }])
            ->first();
        return inertia('Call/History', compact('call'));
    }

    public function storeMessage(MessageRepository $repository, Call $call, Request $request)
    {
        $repository->saveInternalMessage($call, $request?->text, $request?->file);
        return redirect()->back();
    }

    public function sendMessage(MessageRepository $repository, Call $call, MessageStoreRequest $request)
    {
        $repository->sendExternalMessage($call, $request?->text, $request?->file);
        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }

    public function finish(CallRepository $callRepository, Call $call)
    {
        $callRepository->finish($call);
        return redirect()->back();
    }
}
