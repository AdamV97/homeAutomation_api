<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dataController extends Controller
{
    private function converTime($format, $date){
        return date($format, strtotime($date));
    }

    public function lastData()
    {
        $lastData = DB::table('data')
                    ->join('device', 'data.device_id', '=', 'device.id')
                    ->join('room', 'device.room_id', '=', 'room.id')
                    ->where('data.device_id', '=', 1)
                    ->take(1)
                    ->orderByDesc('timestamp')
                    ->get();
        
        $lastData[0]->date = $this->converTime('d.m.Y',$lastData[0]->timestamp);
        $lastData[0]->time = $this->converTime('H:i',$lastData[0]->timestamp);
        return $lastData;
    }

    public function allData()
    {
        $allData = DB::table('data')
                    ->get();
        return $allData;
    }

    public function avgDayData()
    {
        $dayData = DB::select('SELECT * FROM data WHERE timestamp >= now() - INTERVAL 1 DAY AND data.device_id = 1
        ORDER BY `data`.`timestamp` ASC');

        $avgData = [];
        $currentData = [];
        $app = app();
 
        $lastHour = NULL;
        $inital = true;

        foreach($dayData as $value){
            $currentHour = $this->converTime('H', $value->timestamp);

            if($currentHour === $lastHour || $inital){
                array_push($currentData, $value);
            }else{
                $object = $app->make('stdClass');
                $mainObject = $app->make('stdClass');
                $hum = 0;
                $press = 0;
                $temp = 0;

                foreach($currentData as $data){
                    $hum = $hum + $data->humidity;
                    $press = $press + $data->pressure;
                    $temp = $temp + $data->temperature;
                }

                $arrayLength = count($currentData);

                $hum = round($hum / $arrayLength, 2);
                $press = round($press / $arrayLength, 2);
                $temp = round($temp / $arrayLength, 2);

                $object->hour = $currentHour;
                $object->humidity = $hum;
                $object->pressure = $press;
                $object->temperature = $temp;

                array_push($avgData, $object);

                $currentData = [];
                array_push($currentData, $value);

            }
            $inital = false;
            $lastHour = $this->converTime('H', $value->timestamp);
        };

        return $avgData;
    }
}
