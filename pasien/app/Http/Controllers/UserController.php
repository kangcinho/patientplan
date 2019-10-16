<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Helper\RecordLog;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function getDataUser(Request $request){
        // $users = User::orderBy('updated_at', 'desc')->get();
        $users = User::orderBy('updated_at', 'desc')
        ->skip($request->firstPage)
        ->take($request->lastPage)
        ->where('namaUser','like',"%$request->searchNamaUser%")
        ->get();
        $totalUser = User::where('namaUser','like',"%$request->searchNamaUser%")->count();
        return response()->json([
            'users' => $users,
            'totalUser' => $totalUser
        ], 200);
    }

    public function saveDataUser(Request $request){
        $user = User::where('username' , $request->username)->first();
        if($user){
            return response()->json([
                'error' => 'Gagal! Username sudah terdapat pada DB'
            ], 403);
        }
        $user = User::where('email' , $request->email)->first();
        if($user){
            return response()->json([
                'error' => 'Gagal! Email sudah terdapat pada DB'
            ], 403);
        }
        
        $user = new User;
        $user->idUser = $user->getIDUser();
        $user->namaUser = $request->namaUser;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt('123456');
        $user->canAdmin = $request->canAdmin;
        $user->canInsert = $request->canInsert;
        $user->canUpdate = $request->canUpdate;
        $user->canDelete = $request->canDelete;
        $user->canEkspor = $request->canEkspor;
        $user->isEdit = false;
        $user->save();
        RecordLog::logRecord('INSERT', $user->idUser, null, $user, Auth::user()->idUser);
        $status = "Data Username $user->username Berhasil Disimpan!";
        return response()->json([
            'status' => $status,
            'user' => $user
        ], 200);
    }

    public function updateDataUser(Request $request){
        $user = User::where('idUser', $request->idUser)->first();
        $userOld = $user->replicate();

        if($user->username != $request->username){
            $username = User::where('username', $request->username)->first();
            if($username){
                return response()->json([
                    'error' => 'Gagal! Username sudah terdapat pada DB'
                ], 403);
            }
        }

        if($user->email != $request->email){
            $email = User::where('email', $request->email)->first();
            if($email){
                return response()->json([
                    'error' => 'Gagal! Email sudah terdapat pada DB'
                ], 403);
            }
        }
        
        $user->namaUser = $request->namaUser;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->canAdmin = $request->canAdmin;
        $user->canInsert = $request->canInsert;
        $user->canUpdate = $request->canUpdate;
        $user->canDelete = $request->canDelete;
        $user->canEkspor = $request->canEkspor;
        $user->isEdit = false;
        $user->save();
        
        RecordLog::logRecord('UPDATE', $user->idUser, $userOld, $user, Auth::user()->idUser);
        $status = "Data Username $user->username Berhasil DiUpdate!";
        return response()->json([
            'status' => $status,
            'user' => $user
        ], 200);
    }

    public function deleteDataUser($idUser){
        $user = User::where('idUser', $idUser)->first();
        $status = "Data Username $user->username Berhasil Dihapus!";
        RecordLog::logRecord('DELETE', $user->idUser, $user, null, Auth::user()->idUser);
        $user->delete();
        return response()->json([
            'status' => $status,
        ], 200);
    }
}
