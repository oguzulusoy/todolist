<?php

namespace App\Console\Commands;

use App\Models\TaskModel;
use Illuminate\Console\Command;
use App\Services\Task\TaskGateway;
use Illuminate\Support\Facades\DB;
use App\Repositories\TasksRepository;
use HaydenPierce\ClassFinder\ClassFinder;

class InsertTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:tasks {--provider=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command insert all tasks with the given provider';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $tasksRepository;

    public function __construct(TasksRepository $tasksRepository)
    {
        parent::__construct();

        $this->tasksRepository = $tasksRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = $this->option('provider');
        if ($provider){
            $response = $this->fetchData($provider);

            $this->tasksRepository->saveRecord($response);

        }
    }

    /**
     * Fetching currencies amounts from given provider.
     *
     * @param $provider
     * @return mixed
     */
    private function fetchData($provider){
        
        $gateway = new TaskGateway($provider);
        $adapter = $gateway->getClass();
       
        if($adapter)
        {
            $response = $adapter->fetch();

            if ($response['status'] == 200){
                $this->info($response['message']);
                return $response['data'];
            }
            else{
                $this->error($response['message']);
                exit();
            }
        }else{
            $this->error($provider . " name has not found. You can try Provider1 or Provider2");
            exit();
        }
    }
}
