<?php

namespace App\Helpers;

use App\Services\GRPCClient;
use Illuminate\Support\Facades\Log;


class GRPCMessageHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function sendMessage($request, $remoteMethod) 
    {
        $client = GRPCClient::getInstance();

        $attempt = 0;
        $maxRetries = 10; // Максимальное количество попыток

        while ($attempt < $maxRetries) {
            try {
                $responseMessage = $this->send($client, $request, $remoteMethod);

                // Если ответ получен корректно, выходим из цикла
                if ($responseMessage !== null) {
                    return $responseMessage->serializeToJsonString();
                }
            } catch (\Exception $e) {
                Log::error('Exception: ' . $e->getMessage());
            }

            $attempt++;
            // Можно добавить задержку перед повторной попыткой
            usleep(500000); // Задержка 500 мс
        }

        return response()->json(['error' => 'Failed to get a valid response after retries'], 500);
    }

    private function send($client, $request, $remoteMethod)
    {
        list($reply, $status) = $client->$remoteMethod($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            Log::error('gRPC Error: ' . $status->details);
            return null; // Возвращаем null, чтобы продолжить попытки
        }
        return $reply ?? null;
    }
}
