<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;

    public function getDevelopers(){
        return Developer::orderBy('level', 'desc')->get()->toArray();
    }
}
