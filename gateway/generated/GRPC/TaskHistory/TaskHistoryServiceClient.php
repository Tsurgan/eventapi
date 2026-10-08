<?php
// GENERATED CODE -- DO NOT EDIT!

namespace GRPC\TaskHistory;

/**
 */
class TaskHistoryServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GRPC\TaskHistory\ListTaskHistoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTaskHistories(\GRPC\TaskHistory\ListTaskHistoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_history.TaskHistoryService/ListTaskHistories',
        $argument,
        ['\GRPC\TaskHistory\ListTaskHistoriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskHistory\GetTaskHistoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTaskHistory(\GRPC\TaskHistory\GetTaskHistoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_history.TaskHistoryService/GetTaskHistory',
        $argument,
        ['\GRPC\TaskHistory\TaskHistory', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\TaskHistory\DeleteTaskHistoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTaskHistory(\GRPC\TaskHistory\DeleteTaskHistoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/task_history.TaskHistoryService/DeleteTaskHistory',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
