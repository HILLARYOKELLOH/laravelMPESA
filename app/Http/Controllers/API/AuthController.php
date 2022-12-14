<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $validatedata=$request->validate([
'name'=>'required|max:55',
'email'=>'email|required|unique',
'password'=>'required|confirmed'
        ]);

    $validatedata['password']=bcrypt($request->password);
    $user=User::create($validatedata);
    $accessToken=$user->createToken('authToken')->accessToken;
    return response(['user'=>$user,'access_token'=>$accessToken]);

    }
    public function login(Request $request){
        $logindata=$request->validate([
'email'=>'email|required',
'password'=>'required'
        ]);
        if(!auth()->attempt($logindata)){
            return response(['message'=>'Invalid Credentials']);
        }
        $accessToken =auth()->user()->createToken('authToken')->accessToken;
        return response(['user'=>auth()->user(),'access_token'=>$accessToken]);

    }


}
