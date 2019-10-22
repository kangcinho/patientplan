<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTAuth;
class UserAuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if($token = JWTAuth::attempt($credentials)){
            $user = User::find(Auth::user()->idUser);
            return response()->json([
                'status'=>'Login Berhasil',
                'user'=> $user,
                'token' => $token
            ], 200)->header('Authorization', $token);
        }
        return response()->json([
            'error' => 'Login Gagal! Username / Password Salah'
        ],401);
    }

    public function logout(){
        $this->guard()->logout();
        return response()->json([
            'user'=> [],
            'token' => null
        ], 200);
    }

    public function refresh(){
        if ($token = $this->guard()->refresh()) {
            return response()->json([
                'status' => 'refresh success'
            ], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'Refresh Token error'], 401);
    }

    public function user(Request $request){
        $user = User::find(Auth::user()->idUser);
        return response()->json($user, 200);
    }

    private function guard(){
        return Auth::guard();
    }

    public function getUserLogin(){
        if($user = JWTAuth::parseToken()->authenticate()){
            return response()->json([
                'user' => $user
            ],200);
        }

        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses'
        ],401);
    }
}
