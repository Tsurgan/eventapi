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

}
