<?php

namespace App\Services;

use App\Models\TaskStatus as TSModel;
use GRPC\TaskStatus\TaskStatus as TSStructure;
use Spiral\RoadRunner\GRPC;
use GRPC\TaskStatus\TaskStatusServiceInterface;
use GRPC\TaskStatus\ListTaskStatusesRequest;
use GRPC\TaskStatus\ListTaskStatusesResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\Console\Kernel;

use Illuminate\Foundation\Application;

final class GRPCMessenger implements TaskStatusServiceInterface
{

    protected $app;

    public function ListTaskStatuses(GRPC\ContextInterface $ctx, ListTaskStatusesRequest $in): ListTaskStatusesResponse
    {
        //print_r(User::query()->first()->name);

        try {
            /*$greeting = new User();
            $greeting->name = $in->getName();
            $greeting->save();
            print_r($greeting->name);*/

            $response = new ListTaskStatusesResponse();
            $taskStatuses = TSModel::all()->toArray();
            //$rolePermissions = DB::table('task_statuses')->get();
            //$response->setTaskStatuses(TaskStatus::all());

$taskStati = [];
            foreach ($taskStatuses as $item) {
                $taskStati[] = new TSStructure(['id'=> $item['id'],'name' => $item['name']]);
            }
            $response->setTaskStatuses($taskStati);
           // file_put_contents('log.txt', print_r($response->getTaskStatuses(),true), FILE_APPEND | LOCK_EX);
            //$response->setMessage("Hello!");
            return $response;
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            throw new \Exception("Internal server error");
        }
    }
}