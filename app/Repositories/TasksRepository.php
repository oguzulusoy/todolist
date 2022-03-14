<?php

namespace App\Repositories;

use App\Models\TaskModel;
use App\Repositories\Contracts\TasksRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class TasksRepository implements TasksRepositoryInterface
{

    private $taskModel;

    public function __construct(TaskModel $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function saveRecord($data)
    {
        $this->taskModel->saveRecord($data);
    }

    public function allTasks(){
        return $this->taskModel->allTasks();
    }

}