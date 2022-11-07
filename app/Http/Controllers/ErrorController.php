<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Customer;
use App\Models\Error;
use App\Models\Log;
use App\Models\Project;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $customers = Customer::all();
        $errors = Error::query();

        if ($request->id) {
            $errors->where('id', 'like', "%{$request->id}%");
        }

        if ($request->file) {
            $errors->where('file', 'like', "%{$request->file}%");
        }

        if ($request->from) {
            $errors->where('updated_at', '>=', "{$request->from} 00:00:00");
        }

        if ($request->until) {
            $errors->where('updated_at', '<=', "{$request->until} 23:59:59");
        }

        $errors = $errors->orderBy('id', 'desc')->paginate(10);
        return inertia('Error/Index', compact('errors', 'customers', 'projects'));
    }

    public function show(int $id)
    {
        $error = Error::query()->whereId($id)->with('messages.user')->first();
        $logs = Log::query()->whereMorphedTo('logable', $error)->orderBy('created_at', 'desc')->with('customer', 'messages.user')->paginate(10);
        return inertia('Error/Show', compact('error', 'logs'));
    }

    public function log(int $id)
    {
        $log = Log::query()->whereId($id)->with('logable', 'customer')->first();
        return inertia('Error/Log', compact('log'));
    }

    public function storeMessage(MessageRepository $repository, Error $error, MessageStoreRequest $request)
    {
        $repository->saveInternalMessage($error, $request?->text, $request?->file);
        return redirect()->back();
    }
}
