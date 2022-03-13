<?php

namespace App\Repositories;

use App\Models\TaskModel;
use App\Repositories\Contracts\TasksRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class TasksRepository implements TasksRepositoryInterface
{

    private $ordersModel;

    public function __construct(TaskModel $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function saveRecord($data)
    {
        $this->taskModel->saveRecord($data);
    }

    public function allTasks(){
        return TaskModel::where('developerId', 0)
               ->orderBy('level','desc')
               ->get()
               ->toArray();
    }

}