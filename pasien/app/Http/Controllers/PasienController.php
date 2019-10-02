<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
class PasienController extends Controller
{
    public function show(){
        
    }

    public function getDataPasienFromSanata(){
        $tanggalSekarang = \Carbon\Carbon::now()->toDateString();
        $tanggalKemarin = \Carbon\Carbon::now()->subDays(1)->toDateString();
        
        $sanataRegistrasi = \DB::connection('sqlsrv')
                    ->table('SIMtrRegistrasi')
                    ->selectRaw('NoReg as noReg, NRM, NamaPasien_Reg as namaPasien, NoKamar as noKamar, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, BPJSMurni, SilverPlus as silverPlus, NaikKelas as naikKelas')
                    ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
                    ->where('StatusBayar', 'Belum')
                    ->where('RawatInap', 1)
                    ->where('Batal', 0)
                    ->orderBy('NoReg', 'desc')
                    ->get();

        $sanataKasir = \DB::connection('sqlsrv')
                    ->table('SIMtrKasir')
                    ->selectRaw('SIMtrRegistrasi.NoReg as noReg, SIMtrRegistrasi.NRM as NRM, SIMtrRegistrasi.NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoKamar as noKamar, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, SIMtrRegistrasi.BPJSMurni as BPJSMurni, SIMtrRegistrasi.SilverPlus as silverPlus, SIMtrRegistrasi.NaikKelas as naikKelas')
                    ->join('SIMtrRegistrasi', 'SIMtrRegistrasi.NoReg', 'SIMtrKasir.NoReg')
                    ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
                    ->where('SIMtrRegistrasi.RawatInap', '1')
                    ->where('Tanggal','>=', $tanggalKemarin)
                    ->where('Tanggal','<=', $tanggalSekarang)
                    ->where('SIMtrKasir.Batal','0')
                    ->orderBy('SIMtrKasir.NoReg', 'desc')
                    ->get();
        
        $dataPasien = collect();
        $dataPasien = $dataPasien->concat($sanataRegistrasi)->concat($sanataKasir);
        return response()->json($dataPasien);
    }
}
