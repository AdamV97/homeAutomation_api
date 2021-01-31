<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken, 'logedin' => true]);
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function logout()
    { 
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
    }
}
