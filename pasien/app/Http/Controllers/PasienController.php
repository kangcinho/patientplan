<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
class PasienController extends Controller
{
    public function show(){
        $pasien = new Pasien();
        dd($pasien->getIDPasien());
    }

}
