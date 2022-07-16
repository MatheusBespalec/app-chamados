<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallStoreRequest;
use App\Models\Call;
use App\Models\CustomerProject;
use App\Repositories\CallRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CallController extends Controller
{
    public function index()
    {
        $calls = Call::query()->with(['project', 'customer'])->paginate(10);
        return Inertia::render('Call/Index', compact('calls'));
    }

    public function show(int $call_id)
    {
        $call = Call::query()->with(['customer', 'project', 'notes.user'])->first();
        return Inertia::render('Call/Show', compact('call'));
    }

    public function store(CallRepository $repository, CallStoreRequest $request)
    {
        $pivot = CustomerProject::query()->whereUuid($request->uuid)->with(['customer', 'project'])->first();
        $repository->create(
            $request->title,
            $request->description,
            $request->from,
            $request->input('category'),
            $pivot->customer,
            $pivot->project
        );

        return response()->json(['message' => 'Chamado iniciado'], 201);
    }

    public function history(int $id)
    {
        $call = Call::query()->whereId($id)->with('messages')->one();
        return inertia('Call/History', compact('call'));
    }

    public function addNote(NoteRepository $repository, Call $call, Request $request)
    {
        $repository->create($request->message, $call);
        return redirect()->back();
    }
}
