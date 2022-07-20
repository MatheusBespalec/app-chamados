<?php

namespace App\Repositories;

use App\Models\Interfaces\Messageable;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    private function saveFile(UploadedFile $file): string
    {
        return $file->storeAs('messages', Str::random(30) . '.' .  $file->extension());
    }

    public function saveInternalMessage(Messageable $messageagle, ?string $text, ?UploadedFile $file): Message
    {
        if ($file instanceof UploadedFile) {
            $file_name = $this->saveFile($file);
        }

        return Message::create([
            'text' => $text,
            'file_path' => $file_name ?? null,
            'user_id' => Auth::user()->id,
            'external' => true,
            'messageable_type' => $messageagle::class,
            'messageable_id' => $messageagle->id
        ]);
    }

    public function sendExternalMessage(Messageable $messageagle, ?string $text, ?UploadedFile $file): Message
    {
        if ($file instanceof UploadedFile) {
            $file_name = $this->saveFile($file);
        }

        return Message::create([
            'text' => $text,
            'file_path' => $file_name ?? null,
            'from' => Auth::user()->name,
            'external' => true,
            'user_id' => Auth::user()->id,
            'messageable_type' => $messageagle::class,
            'messageable_id' => $messageagle->id
        ]);
    }

    public function receiveExternalMessage(Messageable $messageagle, string $from, ?string $text, ?UploadedFile $file): Message
    {
        if ($file instanceof UploadedFile) {
            $file_name = $this->saveFile($file);
        }

        return Message::create([
            'text' => $text,
            'file_path' => $file_name ?? null,
            'from' => $from,
            'external' => true,
            'messageable_type' => $messageagle::class,
            'messageable_id' => $messageagle->id
        ]);
    }
}
