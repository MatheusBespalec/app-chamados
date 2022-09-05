<?php

namespace App\Http\Controllers\External;

use App\Http\Requests\CallStoreRequest;
use App\Http\Requests\ReceiveMessageRequest;
use App\Models\Call;
use App\Models\CustomerProject;
use App\Repositories\CallRepository;
use App\Repositories\MessageRepository;

class CallApiController extends ApiController
{
    public function store(CallRepository $repository, CallStoreRequest $request)
    {
        $pivot = CustomerProject::query()->whereUuid($request->uuid)->with(['customer', 'project'])->first();
        $call = $repository->create(
            $request->title,
            $request->description,
            $request->from,
            $request->category,
            $pivot->customer,
            $pivot->project
        );

        return $this->response([
            'uuid' => $call->uuid
        ], 201);
    }

    public function receiveMessage(MessageRepository $repository, ReceiveMessageRequest $request)
    {
        $call = Call::find($request->uuid);
        $repository->receiveExternalMessage($call, $request->from, $request?->text, $request?->file);

    }
}
