<?php

namespace App\Services\Task\Adapters;

use GuzzleHttp\Client;
use App\Services\Task\TaskBase;
use App\Services\Task\Contracts\TaskInterface;

class Provider1 extends TaskBase implements TaskInterface{

    public function fetch()
    {
        try{
            $client     =  new Client();
            $request    = $client->get('http://www.mocky.io/v2/5d47f24c330000623fa3ebfa')->getBody()->getContents();
            $response   = json_decode($request, true);

            $data = [];
            foreach($response as $taskIt){
                $data[]   = [
                    'name'  => $taskIt['id'],
                    'level' => $taskIt['zorluk'],
                    'hour'  => $taskIt['sure']];
            }

            return $this->taskResponse(200, 'Provider 1 adapter fetched data succesfully', $data);

        }catch(\Exception $e){
            return $this->taskResponse(503, 'Error: ' . $e->getMessage(), $e);
        }    
    }

}