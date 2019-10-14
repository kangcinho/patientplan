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
            $user = User::find(Auth::user()->idUser);
            return response()->json([
                'status'=>'Login Berhasil',
                'uses'=> $user,
                'token' => $token
            ], 200)->header('Authorization', $token);
        }
        return response()->json([
            'error' => 'Login Gagal'
        ],401);
    }

    public function logout(){
        $this->guard()->logout();
        return response()->json([],200);
    }

    public function refresh(){
        if ($token = $this->guard()->refresh()) {
            return response()->json([
                'status' => 'refresh success'
            ], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    public function user(Request $request){
        $user = User::find(Auth::user()->idUser);
        return response()->json($user, 200);
    }

    private function guard(){
        return Auth::guard();
    }
}
