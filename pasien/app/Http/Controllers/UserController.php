<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Helper\RecordLog;
class UserController extends Controller
{
    public function getDataUser(){
        $users = User::orderBy('updated_at', 'desc')->get();
        return response()->json($users, 200);
    }

    public function saveDataUser(Request $request){
        $user = new User;
        $user->idUser = $user->getIDUser();
        $user->namaUser = $request->namaUser;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = '1212';
        $user->canAdmin = $request->canAdmin;
        $user->canInsert = $request->canInsert;
        $user->canUpdate = $request->canUpdate;
        $user->canDelete = $request->canDelete;
        $user->isEdit = false;
        $user->save();
        RecordLog::logRecord('INSERT', $user->idUser, null, $user);
        return response()->json($user, 200);
    }

    public function updateDataUser(Request $request){
        $user = User::where('idUser', $request->idUser)->first();
        $userOld = $user->replicate();
        // if($user){
            $user->namaUser = $request->namaUser;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->canAdmin = $request->canAdmin;
            $user->canInsert = $request->canInsert;
            $user->canUpdate = $request->canUpdate;
            $user->canDelete = $request->canDelete;
            $user->isEdit = false;
        // }
        $user->save();
        RecordLog::logRecord('UPDATE', $user->idPasien, $userOld, $user);
        return response()->json($user, 200);
    }

    public function deleteDataUser($idUser){
        $user = User::where('idUser', $idUser)->first();
        RecordLog::logRecord('DELETE', $user->idPasien, $user, null);
        $user->delete();
        return response()->json([], 200);
    }
}
