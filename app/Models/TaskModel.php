<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TaskModel extends Model
{
    use HasFactory;

    protected $fillable = ['name','level','hour'];
    protected $table = 'tasks';
    public $timestamps = false;
    
    public function saveRecord($parameters){

         $insertResult = TaskModel::insert($parameters);
    } 

    public function allTasks(){
        return TaskModel::where('developerId', 0)
               ->orderBy('level','desc')
               ->get()
               ->toArray();
    }
}
