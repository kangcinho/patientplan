<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class UserAuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('username', 'password');
        if($token = $this->guard()->attempt($credentials)){
            return response()->json([], 200)->header('Authorization', $token);
        }
        return response()->json([],401);
    }

    public function logout(){
        $this->guard()->logout();
        return response()->json([],200);
    }

    public function user(Request $request){
        $user = User::find(Auth::user()->idUser);
        return response()->json($user, 200);
    }

    private function guard(){
        return Auth::guard();
    }
}
