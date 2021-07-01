<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class weatherDataController extends Controller
{
    public function checkForUpdate(){
        $weatherData = $this->checkDatabase();

        if(!$weatherData){
            $data = $this->callApi();
            return $data;
        }

        return $weatherData;
    }

    private function callApi(){
        $response = Http::get('api.openweathermap.org/data/2.5/weather?q=oriovac&units=metric&appid=' . $_ENV['WEATHER_API']);
        $response = $response->json();
        
        $data = [
            'temp'=> $response['main']['temp'],
            'icon'=> $response['weather'][0]['icon']
        ];

        $this->writeToDatabase($data);

        return $data;
    }

    private function checkDatabase(){
        $lastEntry = WeatherData::latest()->first();

        if($lastEntry !== null){
            $timeFromDatabase = Carbon::parse($lastEntry->created_at);
            $timeToCompare = Carbon::now()->subMinutes(30);
    
            $result = $timeFromDatabase->gt($timeToCompare);
            if($result){
                return $lastEntry;
            }

            return $result;
        }

        return false;
    }

    private function writeToDatabase($data){
        WeatherData::create([
            'temp' => $data['temp'],
            'icon' => $data['icon']
        ]);
    }
}
