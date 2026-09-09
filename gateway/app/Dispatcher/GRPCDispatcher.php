<?php

namespace App\Dispatcher;

use App\RoadRunnerMode;
use Spiral\RoadRunner\EnvironmentInterface;
use GRPC\User\UserServiceInterface;
use GRPC\User\CreateUserRequest;
use GRPC\User\CreateUserResponse;
use App\Services\GRPCMessenger;
use Spiral\RoadRunner\GRPC\Invoker;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

final class GRPCDispatcher implements DispatcherInterface
{
    public function canServe(EnvironmentInterface $env): bool
    {
        return $env->getMode() === RoadRunnerMode::Grpc->value;
    }

    public function serve(): void
    {
        $server = new Server(new Invoker(), [
            'debug' => false, // optional (default: false)
        ]);

        $server->registerService(UserServiceInterface::class, new GRPCMessenger());

        $server->serve(Worker::create());
    }
}