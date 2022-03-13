@extends('pages.layouts.main')
@section('content')
    <div class="container mt-5">
        <h5> Maksimum Task Bitme süresi (Hafta): <strong><?=$totalWeeks?> Hafta</strong></h5>
        <h5> En Geç Bitirme Yaklaşık(Saat): <strong><?=$MaxHour?> Saat </strong></h5>
    </div>
    <div class="row ml-3 container-fluid">

    <?php   
    if(isset($developers) && !empty($developers)): 
        foreach($developers as $developer):?>
                <div class = "col-sm-2 ">
                    <div class="div">
                        <strong class="text-danger"><?=$developer['name']?></strong><br>
                        Yetenek: 1 saatte <strong><?=$developer['level']?></strong> level iş bitiriyor
                        Aşağıdaki Taskı Toplam Bitirme Zamanı Yaklaşık: <strong><?=  $developer['totalTime'] . ' Saat'?></strong>
                        <?php foreach($developer['task'] as $task): ?>
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <ul>
                                            <li>
                                                Task Adı : <?=$task['taskName']?>
                                            </li>
                                            <li>
                                                Task Süresi: <?=$task['hour'] < 1 ? (int)(60 * $task['hour']) ." Dakika"  : (is_int($task['hour']) ? $task['hour'] : number_format($task['hour'],1, '.',',')) ." Saat"?>
                                            </li>
                                            <li>
                                                Zorluk: <?=$task['level']?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    </div>
                </div>
        <? endforeach;
    endif;
    ?>
    </div>
@endsection