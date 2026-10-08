<?php

namespace App\Services;

use App\Models\TaskStatus as TSModel;
use GRPC\TaskStatus\TaskStatus;
use Spiral\RoadRunner\GRPC;
use GRPC\TaskStatus\TaskStatusServiceInterface;
use GRPC\TaskStatus\ListTaskStatusesRequest;
use GRPC\TaskStatus\ListTaskStatusesResponse;
use GRPC\TaskStatus\GetTaskStatusRequest;
use GRPC\TaskStatus\CreateTaskStatusRequest;
use GRPC\TaskStatus\UpdateTaskStatusRequest;
use GRPC\TaskStatus\DeleteTaskStatusRequest;
use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Descriptor;
use Google\Protobuf\FieldDescriptor;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\Console\Kernel;

use Illuminate\Foundation\Application;

final class GRPCMessenger implements TaskStatusServiceInterface
{

    protected $app;

    public function ListTaskStatuses(GRPC\ContextInterface $ctx, ListTaskStatusesRequest $in): ListTaskStatusesResponse
    {
        try {
            $page_token = $in->getPageToken() ?? 1;
            $page_size = $in->getPageSize() ?? 15;
            $taskStatuses = [
                'task_statuses' => TSModel::orderBy('id', 'asc')->paginate($page_size, ['*'], 'page', $page_token), 
                'next_page_token'=> $page_token + 1
            ];

            $response = $this->MapModelToResponse($taskStatuses,'GRPC\TaskStatus\ListTaskStatusesResponse');

            return $response;
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
            throw new \Exception("Internal server error");
        }
    }

    /*
    * Receives data to be put into a response. Key corresponding to field.
    * Format example: ['task_statuses'=> new TaskStatus]
    */

    private function MapModelToResponse($data, string $responseClassName) {

        $responseContent = [];

        foreach ($data as $key => $field) {
            //field is an object
            if (!empty($field)) {
                if (is_object($field)) {
                    if ($field instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                        // field is an array in a paginator
                        $items = $field->items();
                        $grpcClass = $this->ModelClassToGRPCClass(get_class($items[0]));

                        $fieldContent = $this->ObjectSetToContent($items, $grpcClass);
                        
                        $responseContent[$key] = $fieldContent;

                    } elseif ($field instanceof \Illuminate\Database\Eloquent\Collection) {
                        // field is a collection
                        
                        $grpcClass = $this->ModelClassToGRPCClass(get_class($field->first()));

                        $fieldContent = $this->ObjectSetToContent($field, $grpcClass);
                        
                        $responseContent[$key] = $fieldContent;
                    } else {
                        //field is a model object
                        $grpcClass = $this->ModelClassToGRPCClass(get_class($field));

                        $responseContent[$key] = new $grpcClass($field->getAttributes());
                    }
                } else {
                    //field is a variable
                    $responseContent[$key] = $field;
                }
            }
        }

        $response = new $responseClassName($responseContent);
        return $response;

    }

    private function ModelClassToGRPCClass(string $modelClass) 
    {  
        $className = substr($modelClass, strrpos($modelClass, '\\' )+1);
        return 'GRPC\\'.$className.'\\'.$className;
    }

    private function ObjectSetToContent($set, string $grpcClass) 
    {
        $pool = DescriptorPool::getGeneratedPool();
        $descriptor = $pool->getDescriptorByClassName($grpcClass);

        //
        $responseFields = [];
        $protoFields = $descriptor->getField();

        foreach ($protoFields as $protoField) {
            $responseFields[$protoField->getName()] = '';
        }

        $fieldContent = [];
        foreach ($set as $item) {
            $fieldContent[] = new $grpcClass(array_intersect_key($item->getAttributes(),$responseFields));
        }

        return $fieldContent;
    }


    public function GetTaskStatus(GRPC\ContextInterface $ctx, GetTaskStatusRequest $in): TaskStatus
    {
        $reply = new TaskStatus();
        return $reply;

    }

    public function CreateTaskStatus(GRPC\ContextInterface $ctx, CreateTaskStatusRequest $in): TaskStatus
    {
        return new TaskStatus();
    }
    public function UpdateTaskStatus(GRPC\ContextInterface $ctx, UpdateTaskStatusRequest $in): TaskStatus
    {
        return new TaskStatus();
    }

    public function DeleteTaskStatus(GRPC\ContextInterface $ctx, DeleteTaskStatusRequest $in): \Google\Protobuf\GPBEmpty
    {
        return new \Google\Protobuf\GPBEmpty;
    }

}