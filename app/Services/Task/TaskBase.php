<?php 

namespace app\Services\Task;

class TaskBase
{
    /**
     * @param bool $status
     * @param string $message
     * @param null $data
     * @return array
     */
    protected function taskResponse($status = false, $message = '', $data = null){
        return [
            'status' =>  $status,
            'message' => $message,
            'data' => $data
        ];
    }
}