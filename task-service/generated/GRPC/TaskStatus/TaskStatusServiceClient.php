<?php
// GENERATED CODE -- DO NOT EDIT!

namespace GRPC\TaskStatus;

/**
 */
class TaskStatusServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GRPC\TaskStatus\ListTaskStatusesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTaskStatuses(\GRPC\TaskStatus\ListTaskStatusesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_status.TaskStatusService/ListTaskStatuses',
        $argument,
        ['\GRPC\TaskStatus\ListTaskStatusesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskStatus\GetTaskStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTaskStatus(\GRPC\TaskStatus\GetTaskStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_status.TaskStatusService/GetTaskStatus',
        $argument,
        ['\GRPC\TaskStatus\TaskStatus', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskStatus\CreateTaskStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTaskStatus(\GRPC\TaskStatus\CreateTaskStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_status.TaskStatusService/CreateTaskStatus',
        $argument,
        ['\GRPC\TaskStatus\TaskStatus', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskStatus\UpdateTaskStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTaskStatus(\GRPC\TaskStatus\UpdateTaskStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_status.TaskStatusService/UpdateTaskStatus',
        $argument,
        ['\GRPC\TaskStatus\TaskStatus', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskStatus\DeleteTaskStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTaskStatus(\GRPC\TaskStatus\DeleteTaskStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_status.TaskStatusService/DeleteTaskStatus',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
