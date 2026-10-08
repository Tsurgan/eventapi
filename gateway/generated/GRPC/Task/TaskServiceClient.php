<?php
// GENERATED CODE -- DO NOT EDIT!

namespace GRPC\Task;

/**
 */
class TaskServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GRPC\Task\ListTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTasks(\GRPC\Task\ListTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task.TaskService/ListTasks',
        $argument,
        ['\GRPC\Task\ListTasksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Task\GetTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTask(\GRPC\Task\GetTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task.TaskService/GetTask',
        $argument,
        ['\GRPC\Task\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Task\CreateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTask(\GRPC\Task\CreateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task.TaskService/CreateTask',
        $argument,
        ['\GRPC\Task\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Task\UpdateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTask(\GRPC\Task\UpdateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task.TaskService/UpdateTask',
        $argument,
        ['\GRPC\Task\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Task\DeleteTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTask(\GRPC\Task\DeleteTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task.TaskService/DeleteTask',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
