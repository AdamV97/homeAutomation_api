<?php

namespace App\Http\Controllers;

use App\Models\InstallationToken;
use Illuminate\Http\Request;

class installationTokenController extends Controller
{
    public function saveToken(Request $request){
        $data = $request->validate([
            'token' => 'string|required'
        ]);

        InstallationToken::create([
            'token' => $data['token']
        ]);
    }
}
