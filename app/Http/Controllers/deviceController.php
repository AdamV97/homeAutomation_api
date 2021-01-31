<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deviceController extends Controller
{
    public function deviceStatus()
    {
        $deviceData = DB::select("SELECT data.battery,data.voltage, data.linkquality, device.name, room.room_name, device_type.type FROM data,(select data.*, max(timestamp) AS order_date
        FROM data
        GROUP BY data.device_id) max_date
        JOIN device ON max_date.device_id = device.id
        JOIN room ON device.room_id = room.id
        JOIN device_type ON device.type_id = device_type.id
        WHERE data.device_id=max_date.device_id AND data.timestamp=max_date.order_date");

        return $deviceData;
    }
}
