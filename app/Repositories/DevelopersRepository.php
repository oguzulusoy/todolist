<?php

namespace App\Repositories;

use App\Models\Developer;
use GuzzleHttp\Psr7\Request;
use App\Repositories\Contracts\DevelopersRepositoryInterface;

class DevelopersRepository implements DevelopersRepositoryInterface
{

    private $developersModel;

    public function __construct(Developer $developersModel)
    {
        $this->developersModel = $developersModel;
    }

    public function allDevelopers(){
        return $this->developersModel->allDevelopers();
    }

}