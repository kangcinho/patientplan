<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    //Section Pasien Pulang
    Route::get('getDataPasienRegistrasiFromSanata', 'PasienController@getDataPasienRegistrasiFromSanata');
    Route::get('getDataPetugasFromSanata', 'PasienController@getDataPetugasFromSanata');
    Route::post('saveDataPasienPulang', 'PasienController@saveDataPasienPulang')->middleware('canInsert');
    Route::post('getDataPasienPulang', 'PasienController@getDataPasienPulang');
    Route::post('updateDataPasienPulang', 'PasienController@updateDataPasienPulang')->middleware('canUpdate');
    Route::get('deleteDataPasienPulang/{idPasien}', 'PasienController@deleteDataPasienPulang')->middleware('canDelete');

    //Section User
    Route::post('getDataUser', 'UserController@getDataUser')->middleware('canAdmin');
    Route::post('saveDataUser', 'UserController@saveDataUser')->middleware('canAdmin');
    Route::post('updateDataUser', 'UserController@updateDataUser')->middleware('canAdmin');
    Route::get('deleteDataUser/{idUser}', 'UserController@deleteDataUser')->middleware('canAdmin');

    //EXPORT DATA
    Route::post('getDataExportPasienPulang', 'PasienController@getDataExportPasienPulang')->middleware('canEkspor');
});

//Automatisasi Riwata Pasien Pulang with Cronjob
Route::get('autoGetPasien', 'PasienController@autoGetPasien');

//AUTH
Route::post('login','UserAuthController@login');
Route::get('logout', 'UserAuthController@logout');
Route::get('refresh', 'UserAuthController@refresh');