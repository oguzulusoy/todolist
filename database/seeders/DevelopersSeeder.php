<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("developers")->insert([
            [
                "id"        => 1,
                "name"      => "Murat Developer",
                "level"     => 1,
                "hour"      => 1
            ],
            [
                "id"        => 2,
                "name"      => "Ahmet Developer",
                "level"     => 2,
                "hour"      => 1
            ],
            [
                "id"        => 3,
                "name"      => "Hüseyin Developer",
                "level"     => 3,
                "hour"      => 1
            ],
            [
                "id"        => 4,
                "name"      => "Yusuf Developer",
                "level"     => 4,
                "hour"      => 1
            ],
            [
                "id"        => 5,
                "name"      => "Ayşe Developer",
                "level"     => 5,
                "hour"      => 1
            ]
        ]);
    }
}
