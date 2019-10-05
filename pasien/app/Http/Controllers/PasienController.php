<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
class PasienController extends Controller
{
    public function show(){
        
    }

    public function getDataPasienRegistrasiFromSanata(){
        $tanggalSekarang = \Carbon\Carbon::now()->toDateString();
        $tanggalKemarin = \Carbon\Carbon::now()->subDays(1)->toDateString();
        
        $sanataRegistrasi = \DB::connection('sqlsrv')
                    ->table('SIMtrRegistrasi')
                    ->selectRaw('NoReg as noReg, NRM as nrm, NamaPasien_Reg as namaPasien, NoKamar as kamar, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, BPJSMurni, SilverPlus as silverPlus, NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
                    ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
                    ->leftjoin('mCustomer', 'mCustomer.Kode_Customer', 'SIMtrRegistrasi.KodePerusahaan')
                    ->where('StatusBayar', 'Belum')
                    ->where('RawatInap', 1)
                    ->where('Batal', 0)
                    ->orderBy('NoReg', 'asc')
                    ->get();

        $sanataKasir = \DB::connection('sqlsrv')
                    ->table('SIMtrKasir')
                    ->selectRaw('SIMtrRegistrasi.NoReg as noReg, SIMtrRegistrasi.NRM as nrm, SIMtrRegistrasi.NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoKamar as kamar, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, SIMtrRegistrasi.BPJSMurni as BPJSMurni, SIMtrRegistrasi.SilverPlus as silverPlus, SIMtrRegistrasi.NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
                    ->join('SIMtrRegistrasi', 'SIMtrRegistrasi.NoReg', 'SIMtrKasir.NoReg')
                    ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
                    ->leftjoin('mCustomer', 'mCustomer.Kode_Customer', 'SIMtrRegistrasi.KodePerusahaan')
                    ->where('SIMtrRegistrasi.RawatInap', '1')
                    ->where('Tanggal','>=', $tanggalKemarin)
                    ->where('Tanggal','<=', $tanggalSekarang)
                    ->where('SIMtrKasir.Batal','0')
                    ->orderBy('SIMtrKasir.NoReg', 'asc')
                    ->get();
        
        $dataPasiens = collect();
        $dataPasiens = $dataPasiens->concat($sanataRegistrasi)->concat($sanataKasir);
        foreach($dataPasiens as $dataPasien){
            if($dataPasien->jenisKerjasama == "UMUM"){
                $dataPasien->keterangan = "Umum";
            }else if($dataPasien->jenisKerjasama == "BPJS"){
                if($dataPasien->BPJSMurni){
                    $dataPasien->keterangan = "BPJS - BPJS Murni";
                }else if($dataPasien->silverPlus){
                    $dataPasien->keterangan = "BPJS - Silver Plus";
                }else if($dataPasien->naikKelas){
                    $dataPasien->keterangan = "BPJS - Silver Top Up";
                }else{
                    $dataPasien->keterangan = "BPJS";
                }
            }else{
                $dataPasien->keterangan = "IKS - ".$dataPasien->namaPerusahaan;
            }
        }
        return response()->json($dataPasiens);
    }
    
    public function getDataPetugasFromSanata(){
        $dataPetugasSanata =  \DB::connection('sqlsrv')
                ->table('mCustomer')
                ->selectRaw('Nama_Customer as namaCustomer')
                ->where('Kode_Kategori', 'CC-002')
                ->where('Active', '1')
                ->get();
        return response()->json($dataPetugasSanata);
    }
    public function getDataPasienPulang(){
        $dataPasien = Pasien::all();

        return response()->json($dataPasien, 200);
    }

    public function saveDataPasienPulang(Request $request){

        $tanggal = $this->convertDate($request->tanggal);
        $dataPasien = Pasien::where('noreg', $request->noreg)->get();

        if(count($dataPasien)){
            return response()->json([], 500);
        }else{
            $dataPasien = new Pasien;
            $dataPasien->idPasien = $dataPasien->getIDPasien();
            $dataPasien->noreg = $request->noreg;
            $dataPasien->tanggal = $tanggal;
            $dataPasien->nrm = $request->nrm;
            $dataPasien->namaPasien = $request->namaPasien;
            $dataPasien->kamar = $request->kamar;
            $dataPasien->keterangan = $request->keterangan;
            $dataPasien->idUser = null;
            $dataPasien->waktuVerif = null;
            $dataPasien->waktuIKS = null;
            $dataPasien->waktuSelesai = null;
            $dataPasien->waktuPasien = null;
            $dataPasien->waktuLunas = null;
            $dataPasien->petugasFO = null;
            $dataPasien->petugasPerawat = null;

            if($request->isWaktu){
                if($request->waktuVerif != null){
                    $dataPasien->waktuVerif = $this->convertDate($request->waktuVerif);
                }
                if($request->waktuIKS != null){
                    $dataPasien->waktuIKS = $this->convertDate($request->waktuIKS);
                }
                if($request->waktuSelesai != null){
                    $dataPasien->waktuSelesai = $this->convertDate($request->waktuSelesai);
                }
                if($request->waktuPasien != null){
                    $dataPasien->waktuPasien = $this->convertDate($request->waktuPasien);
                }
                if($request->waktuLunas != null){
                    $dataPasien->waktuLunas = $this->convertDate($request->waktuLunas);
                }  
                $dataPasien->petugasFO = $request->petugasFO;
                $dataPasien->petugasPerawat = $request->petugasPerawat;    
            }
            $dataPasien->save();
            return response()->json($dataPasien, 200);
        }
        return response()->json($dataPasien, 200);
    }
    public function updateDataPasienPulang(Request $request){
        $pasienPulang = Pasien::where('idPasien', $request->idPasien)->first();
        if($pasienPulang){
            if($request->waktuVerif != null){
                $pasienPulang->waktuVerif = $this->convertDate($request->waktuVerif);
            }
            if($request->waktuIKS != null){
                $pasienPulang->waktuIKS = $this->convertDate($request->waktuIKS);
            }
            if($request->waktuSelesai != null){
                $pasienPulang->waktuSelesai = $this->convertDate($request->waktuSelesai);
            }
            if($request->waktuPasien != null){
                $pasienPulang->waktuPasien = $this->convertDate($request->waktuPasien);
            }
            if($request->waktuLunas != null){
                $pasienPulang->waktuLunas = $this->convertDate($request->waktuLunas);
            }
            $pasienPulang->petugasFO = $request->petugasFO;
            $pasienPulang->petugasPerawat = $request->petugasPerawat;
            $pasienPulang->save();
            return response()->json($pasienPulang, 200);
        }
        return response()->json([], 500);
    }

    public function convertDate($date){
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
