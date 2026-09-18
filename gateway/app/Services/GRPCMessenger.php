<?php

namespace App\Services;

use App\Models\User;
use Spiral\RoadRunner\GRPC;
use GRPC\TaskStatus\TaskStatusServiceInterface;
use GRPC\TaskStatus\ListTaskStatusesRequest;
use GRPC\TaskStatus\ListTaskStatusesResponse;

final class GRPCMessenger implements TaskStatusServiceInterface
{
    public function ListTaskStatuses(GRPC\ContextInterface $ctx, ListTaskStatusesRequest $in): ListTaskStatusesResponse
    {
        //print_r(User::query()->first()->name);

        try {
            /*$greeting = new User();
            $greeting->name = $in->getName();
            $greeting->save();
            print_r($greeting->name);*/
            $response = new  ListTaskStatusesResponse();
            //$response->setMessage("Hello!");
            return $response;
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            throw new \Exception("Internal server error");
        }
    }
}