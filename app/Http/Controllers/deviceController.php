<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deviceController extends Controller
{
    public function allDevices()
    {
        $allData = DB::table('device')
                    ->join('room', 'device.room_id', '=', 'room.id')
                    ->select('device.*', 'room.room_name')
                    ->get();
        return $allData;
    }
}
