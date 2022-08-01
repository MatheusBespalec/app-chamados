<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Customer;
use App\Models\Error;
use App\Models\Log;
use App\Repositories\ErrorRepository;
use App\Repositories\MessageRepository;
use App\Repositories\NoteRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorController extends Controller
{
    public function index(Request $request)
    {
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
            Debugbar::info($request->until);
            $errors->where('updated_at', '<=', "{$request->until} 23:59:59");
        }

        $errors = $errors->paginate(10);
        return inertia('Error/Index', compact('errors'));
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
