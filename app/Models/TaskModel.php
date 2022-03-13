<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TaskModel extends Model
{
    use HasFactory;

    protected $fillable = ['name','level','hour'];
    protected $table = 'tasks';
    public $timestamps = false;
    
    public function saveRecord($parameters){

         $insertResult = DB::table('tasks')->insert($parameters);
    } 
}
