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

        if (!\Auth::attempt($loginData)) {
            return response(['logedin' => false,'message' => 'Invalid Credentials']);
        }

        $accessToken = \Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => \Auth::user(), 'access_token' => $accessToken, 'logedin' => true]);
    }

    public function logout(Request $request)
    { 
        $request->user()->token()->revoke();
        return response(['logedin' => false, 'message' => 'Succesfully Signed out!']);
    }
}
