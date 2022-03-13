<?php

namespace App\Services\Task;

class TaskGateway{
    private $namespace = null;

    public function __construct($provider)
    {
        $namespace = '\\App\\Services\\Task\\Adapters\\' . $provider;
        if(class_exists($namespace)){
            $this->namespace = new $namespace;
        }
    }

    public function getClass()
    {
        return $this->namespace;
    }
}