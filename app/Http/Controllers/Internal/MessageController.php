<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->back()->with('success', 'Messagem excluida');
    }
}
