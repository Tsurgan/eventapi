<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Console\Output\ConsoleOutput;

class ListenToRedisStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:listen-to-redis-stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to stream and process events';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        while (true) {
            $response = Redis::xread(1, 2000, ['laravel-database-orders-stream'], '$');

            if (empty($response)) {           
                continue;
            }

            foreach ($response['laravel-database-orders-stream'] as $orderId => $payload) {

                $messageId = array_shift($payload);

                $dataReceived = [];
                $count = count($payload);

                for ($i = 0; $i < $count; $i += 2) {
                    $dataReceived[$payload[$i]] = $payload[$i + 1];
                }

            }
            
            break;
        }
    }
}
