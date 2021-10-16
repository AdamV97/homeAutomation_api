<?php

namespace App\Http\Controllers;

use App\Models\customSettings as ModelsCustomSettings;
use CustomSettings;
use Illuminate\Http\Request;

class customSettingsController extends Controller
{
    public function getSettings(){
        return ModelsCustomSettings::all();
    }

    public function setSettings(Request $request){
        $setting = ModelsCustomSettings::where('id', $request['id'])->first();
        $setting->value = $request['value'];
        $setting->save();

        return true;
    }
}
