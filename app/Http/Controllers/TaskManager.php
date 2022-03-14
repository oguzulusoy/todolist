<?php

namespace App\Http\Controllers;

use Developers;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\TasksRepository;
use App\Repositories\DevelopersRepository;

class TaskManager extends Controller
{

    private $tasksRepository;
    private $developersRepository;

    public function __construct(TasksRepository $tasksRepository, DevelopersRepository $developersRepository)
    {
        $this->tasksRepository = $tasksRepository;
        $this->developersRepository = $developersRepository;
    }
    
    public function index(){
        $tasks = $this->tasksRepository->allTasks();
        if(!$tasks){
            return view('tasks');exit();
        }

        $developers = $this->developersRepository->allDevelopers();
        
        $taskGroupLevel = [];
        
        foreach($tasks as $task){
            $taskGroupLevel[$task['level']][] = $task;
        }

        $minSameTaskCount = min(count($taskGroupLevel[5]), count($taskGroupLevel[4]), count($taskGroupLevel[3]), count($taskGroupLevel[2]), count($taskGroupLevel[1]));

        //Each developer receives an equal amount of tasks according to their level
        for($i=0;$i<$minSameTaskCount;$i++){
            for($j=0;$j<5;$j++){
                $pointer = 5-$j;
                $developers[$j]['task'][] = [
                    'taskName'      => $taskGroupLevel[$pointer][$i]['name'],
                    'level'         => $taskGroupLevel[$pointer][$i]['level'],
                    'hour'          => $developers[$j]['hour'],
                    'estimatedHour' => $taskGroupLevel[$pointer][$i]['hour'],
                ];
            }
        }

        $totalTime[0] = 0;
        $totalTime[1] = 0;
        $totalTime[2] = 0;

        //For level 5,4,3 the best choice developers levels 5,4,3 if we add level 2 it would take more time if we applied

        for($level=5;$level>2;$level--){
            $remainings = array_slice($taskGroupLevel[$level], $minSameTaskCount);
            if($remainings){
                $i = 0;
                foreach($remainings as $remaining){
                    if($i == 3)
                        $i = 0;
    
                    $totalTime[$i] += (float)($level / $developers[$i]['level']);

                    $developers[$i]['task'][] = [
                        'taskName'      => $remaining['name'],
                        'level'         => $remaining['level'],
                        'hour'          => ((float)($level / $developers[$i]['level'])),
                        'estimatedHour' => $remaining['hour'],
                    ];
    
                    $i++;
                }
            }
        }
        
        $minTotalTime = (int)min($totalTime[0], $totalTime[1], $totalTime[2]);
        
        for($dev=3;$dev<5;$dev++){
            $level = 5 - $dev;
            $remainings = array_slice($taskGroupLevel[$level], $minSameTaskCount, $minTotalTime + 1);
            
            if($remainings){
                foreach($remainings as $remaining){
                    $level = 5 - $dev;
                    $developers[$dev]['task'][] = [
                        'taskName'      => $remaining['name'],
                        'level'         => $remaining['level'],
                        'hour'          => $developers[$dev]['hour'],
                        'estimatedHour' => $remaining['hour'],
                    ];
                }
            }

            $lastRecord = $minSameTaskCount+$minTotalTime + 1;
            $remainings = array_slice($taskGroupLevel[$level], $lastRecord);


            if($remainings){
                $i = 0;
                foreach($remainings as $remaining){
                    if($i == 3)
                        $i = 0;

                    $developers[$i]['task'][] = [
                        'taskName'      => $remaining['name'],
                        'level'         => $remaining['level'],
                        'hour'          => (float)($level / $developers[$i]['level']),
                        'estimatedHour' => $remaining['hour'],
                    ];

                    $i++;
                }

            }
        }   
        
        $developers[0]['totalTime'] = round(array_sum(array_column($developers[0]['task'],'hour')));
        $developers[1]['totalTime'] = round(array_sum(array_column($developers[1]['task'],'hour')));
        $developers[2]['totalTime'] = round(array_sum(array_column($developers[2]['task'],'hour')));
        $developers[3]['totalTime'] = round(array_sum(array_column($developers[3]['task'],'hour')));
        $developers[4]['totalTime'] = round(array_sum(array_column($developers[4]['task'],'hour')));

        $takesTasksAsHour = max($developers[0]['totalTime'], $developers[1]['totalTime'], $developers[2]['totalTime'] , $developers[3]['totalTime'] , $developers[4]['totalTime']);
        $params = array(
            'MaxHour' => $takesTasksAsHour,
            'totalWeeks' => ceil($takesTasksAsHour / 45)
        );

        return view('tasks',['developers' => $developers], $params);           
    } 
}
