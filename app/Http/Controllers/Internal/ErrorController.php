<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorRequest;
use App\Models\Customer;
use App\Models\Error;
use App\Models\Log;
use App\Repositories\ErrorRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorController extends Controller
{
    public function index()
    {
        $errors = Error::query()->paginate(10);
        return inertia('Error/Index', compact('errors'));
    }

    public function show(Error $error)
    {
        $logs = Log::query()->whereMorphedTo('logable', $error)->orderBy('created_at', 'desc')->with('customer', 'notes.user')->paginate(10);
        return inertia('Error/Show', compact('error', 'logs'));
    }

    public function log(Log $log)
    {
        $log->load('logable');
        $log->load('customer');

        return inertia('Error/Log', compact('log'));
    }

    /**
     * Create a new Attack, or updatte if already exists this attack and create a new attack log
     *
     * @param AttackRequest $request
     * @param AttackRepository $attackRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ErrorRequest $request, ErrorRepository $errorRepository)
    {
        $errorRepository->create(
            $request->code,
            $request->message,
            $request->file,
            $request->line,
            $request->url,
            $request->trace,
            $request->request_data,
            Customer::query()->whereUuid($request->customer_uuid)
        );

        return response()->json(status: 204);
    }

    public function addNote(NoteRepository $repository, Error $error, Request $request)
    {
        $repository->create($request->message, $error);
        return redirect()->back();
    }
}
