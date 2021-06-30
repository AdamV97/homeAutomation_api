<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;

class alarmController extends Controller
{

    public function getAlarms(){
        return Alarm::get();
    }

    public function checkAlarm(Request $request){

        $data = $request->validate([
            'id' => 'int|required'
        ]);

        $active = Alarm::find($data['id']);

        if($active->active){
            return true;
        }
        
        return false;
    }

    public function setAlarm(Request $request){

        $data = $request->validate([
            'id' => 'int|required',
            'active' => 'int'
        ]);

        $alarm = Alarm::find((int)$data['id']);

        $alarm->active = (int)$data['active'];
        $alarm->save();

        return 'alarm_set';
    }
}