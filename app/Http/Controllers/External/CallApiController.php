<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallStoreRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\ReceiveMessageRequest;
use App\Models\Call;
use App\Models\CustomerProject;
use App\Repositories\CallRepository;
use App\Repositories\MessageRepository;

class CallApiController extends Controller
{
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

    public function receiveMessage(MessageRepository $repository, ReceiveMessageRequest $request)
    {
        $call = Call::find($request->uuid);
        $repository->receiveExternalMessage($call, $request->from, $request?->text, $request?->file);
    }
}
