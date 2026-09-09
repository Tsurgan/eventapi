<?php

namespace App\Services;

use App\Models\User;
use Spiral\RoadRunner\GRPC;
use GRPC\User\UserServiceInterface;
use GRPC\User\CreateUserRequest;
use GRPC\User\CreateUserResponse;

final class GRPCMessenger implements UserServiceInterface
{
    public function CreateUser(GRPC\ContextInterface $ctx, CreateUserRequest $in): CreateUserResponse
    {
        //print_r(User::query()->first()->name);

        try {
            /*$greeting = new User();
            $greeting->name = $in->getName();
            $greeting->save();
            print_r($greeting->name);*/
            $response = new CreateUserResponse();
            $response->setMessage("Hello!");
            return $response;
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            throw new \Exception("Internal server error");
        }
    }
}