<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Support\Str;
use App\Interfaces\Messageable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function create(Messageable $messageagle, ?string $text, ?UploadedFile $file, ?string $from = null): Message
    {
        if ($file instanceof UploadedFile) {
            $file_name = $file->storeAs('messages', Str::random(30) . '.' .  $file->extension());
        }
        return Message::create([
            'text' => $text,
            'file_path' => $file_name,
            'from' => $from ?: Auth::user()->name,
            'user_id' => Auth::user()->id,
            'messageable_type' => $messageagle::class,
            'messageable_id' => $messageagle->id
        ]);
    }
}
