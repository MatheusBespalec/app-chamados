<?php

namespace App\Http\Controllers;

use App\Conections\BancoDigital\Modules\HelpDesk;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Call;
use App\Repositories\CallRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CallController extends Controller
{
    public function index()
    {
        $calls = Call::query()->orderBy('id', 'desc')->with(['project', 'customer'])->paginate(10);
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

    public function sendMessage(MessageRepository $repository, Call $call, MessageStoreRequest $request, HelpDesk $helpDesk)
    {
        session()->flash('error', 'Houve um erro ao enviar a mensagem');
        DB::transaction(function () use ($repository, $helpDesk, $call, $request) {
            $message = $repository->saveExternalMessage($call, $request?->text, $request?->file);
            $helpDesk->sendCallMessage($message, $call);
            session()->flash('success', 'Mensagem enviada com sucesso!');

        });

        return redirect()->back();
    }

    public function finish(CallRepository $callRepository, Call $call)
    {
        $callRepository->finish($call);
        return redirect()->back();
    }
}
