<?php

use GRPC\User\UserServiceInterface;
use GRPC\User\CreateUserRequest;
use GRPC\User\CreateUserResponse;
use App\Services\GRPCMessenger;
use Spiral\RoadRunner\GRPC\Invoker;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';
require 'app/Services/GRPCMessenger.php';

$server = new Server(new Invoker(), [
    'debug' => false, // optional (default: false)
]);

$server->registerService(UserServiceInterface::class, new GRPCMessenger());

$server->serve(Worker::create());