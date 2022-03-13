<?php

namespace App\Http\Controllers;

use Developers;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\TasksRepository;

class TaskManager extends Controller
{

    private $tasksRepository;

    public function __construct(TasksRepository $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }
    
    public function index(){
        /**
         * Algoritmanın doğru çalışması için tasklar ve developerlar levellerine göre sıralı bir şekilde çekildi
         * İlk önce gelen tasklarda minimum aynı eşitlikte olan leveller kullanıcıların levellerine göre yerleştirildi ve kuyruktan çıkarıldı
         * Artık her kullanıcı kendi leveline göre 1 er saat mesgul bulunmakta ve hepsi aynı sürede işi bitirdiğini varsayıp yeteneklerine gore;
         * Kuyrukta kalan diğer işler levellerine göre sırasıyla 5 4 3 level ki bu leveller yüksek olanlar yakınlık durumuna göre 5, 4 ve 3 levelli
         * calisanlar arasında paylasildi 1 ve 2 nin yüksek katları olduklarından dolayı dahil edilmedi bu süre zarfında gecen süre hesaplandı
         * Mininum harcanan süreyi cıkardım 5,4,3 levelleri için 
         * 3,4,5 için Minimum harcanan saat kadar  1 ve 2 numaralı yetenekte ki çalışanlar kendi işlerini halledibilirler onlarda hesaplandı
         * en son kalan 1 ve 2 de ki işler daha cabuk bitmesi acısından 5,4 ve 3 arasında paylasıldı
         * Minimum süre elde edildi
         * */
        $tasks = $this->tasksRepository->allTasks();

        $developers = new Developer();
        $developers = $developers->getDevelopers();
        
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
