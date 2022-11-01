<?php

namespace App\Conections\BancoDigital\Modules;

use App\Models\Call;
use App\Models\Message;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class HelpDesk
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function sendCallMessage(Message $message, Call $call): void
    {
        if ($call->id != $message->messageable_id) {
            throw new InvalidArgumentException('The message not belogns to this call');
        }
        if (!empty($message->file_path)) {
            $fullPath = storage_path('app/' . $message->file_path);
            $fileParts = explode('.', $message->file_path);
            $extension = end($fileParts);
            $fileContent = base64_encode(file_get_contents($fullPath));
        }

        $response = $this->httpClient->get($call->customer->bancoDigital->webhook, [
            RequestOptions::JSON => [
                'message' => $message->text,
                'file' => $fileContent ?? null,
                'call_uuid' => $call->uuid,
                'extension' => $extension ?? null
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception('An error occurred in banco digital');
        }
    }
}
