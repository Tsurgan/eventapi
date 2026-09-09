<?php

namespace App\Services;

use Grpc\ChannelCredentials;
use GRPC\User\UserServiceInterface;
use GRPC\User\CreateUserRequest;
use GRPC\User\UserServiceClient;

class GRPCClient
{
    private static $instance = null;

    private $client;

    private function __construct()
    {
        $this->client = new UserServiceClient(config('octane.grpc_server_host').':'.config('octane.grpc_server_port'), [
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
