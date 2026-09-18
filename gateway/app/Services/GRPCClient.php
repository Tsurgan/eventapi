<?php

namespace App\Services;

use Grpc\ChannelCredentials;
use GRPC\TaskStatus\TaskStatusServiceInterface;
use GRPC\TaskStatus\ListTaskStatusesRequest;
use GRPC\TaskStatus\TaskStatusServiceClient;

class GRPCClient
{
    private static $instance = null;

    private $client;

    private function __construct()
    {
        $this->client = new TaskStatusServiceClient(config('octane.task_grpc_server_host').':'.config('octane.task_grpc_server_port'), [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->client;
    }
}
