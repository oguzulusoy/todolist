<?php

namespace App\Services\Task\Adapters;

use GuzzleHttp\Client;
use App\Services\Task\TaskBase;
use App\Services\Task\Contracts\TaskInterface;

class Provider2 extends TaskBase implements TaskInterface{

    public function fetch()
    {
        try{
            $client     =  new Client();
            $request    = $client->get('http://www.mocky.io/v2/5d47f235330000623fa3ebf7')->getBody()->getContents();
            $response   = json_decode($request, true);
            $data = [];
            
            foreach($response as $key => $taskIt){
                $data[]   = [
                    'name'  => array_keys($taskIt)[0],
                    'level' => array_column($taskIt,'level')[0],
                    'hour'  => array_column($taskIt, 'estimated_duration')[0]];
                }
                
            return $this->taskResponse(200, 'Provider 2 adapter fetched data succesfully', $data);

        }catch(\Exception $e){
            return $this->taskResponse(503, 'Error: ' . $e->getMessage(), $e);
        }    
    }

}