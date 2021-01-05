<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dataController extends Controller
{
    public function lastData()
    {
        $lastData = DB::table('data')
                    ->take(1)
                    ->orderByDesc('timestamp')
                    ->get();
        return $lastData;
    }

    public function allData()
    {
        $allData = DB::table('data')
                    ->get();
        return $allData;
    }
}
