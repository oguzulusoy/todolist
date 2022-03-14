<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;

    public function allDevelopers(){
        return Developer::orderBy('level', 'desc')->get()->toArray();
    }
}
