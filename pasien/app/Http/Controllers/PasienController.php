<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Http\Helper\RecordLog;
class PasienController extends Controller
{
    public function getDataPasienRegistrasiFromSanata(){
        $tanggalSekarang = \Carbon\Carbon::now()->toDateString();
        $tanggalKemarin = \Carbon\Carbon::now()->subDays(1)->toDateString();
        
        $sanataRegistrasi = \DB::connection('sqlsrv')
                    ->table('SIMtrRegistrasi')
                    ->selectRaw('NoReg as noReg, NRM as nrm, NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoAnggota as noKartu, NoKamar as kamar, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, BPJSMurni, SilverPlus as silverPlus, NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
                    ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
                    ->leftjoin('mCustomer', 'mCustomer.Kode_Customer', 'SIMtrRegistrasi.KodePerusahaan')
                    ->where('StatusBayar', 'Belum')
                    ->where('RawatInap', 1)
                    ->where('Batal', 0)
                    ->orderBy('NoReg', 'asc')
                    ->get();

        $sanataKasir = \DB::connection('sqlsrv')
                    ->table('SIMtrKasir')
                    ->selectRaw('SIMtrRegistrasi.NoReg as noReg, SIMtrRegistrasi.NRM as nrm, SIMtrRegistrasi.NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoKamar as kamar, SIMtrRegistrasi.NoAnggota as noKartu, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, SIMtrRegistrasi.BPJSMurni as BPJSMurni, SIMtrRegistrasi.SilverPlus as silverPlus, SIMtrRegistrasi.NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
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

            $cekPasien = Pasien::where('noReg', $dataPasien->noReg)->first();
            if($cekPasien){
                $dataPasien->isDone = true;
            }else{
                $dataPasien->isDone = false;
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

    public function getDataPasienPulang(Request $request){
        $dataPasien = null;
        $totalDataPasien = null;
        if($request->tanggalSearch != null OR $request->tanggalSearch != ''){
            $tglSearch = explode(' ',$this->convertDate($request->tanggalSearch))[0];
            $dataPasien = Pasien::orderBy('tanggal', 'desc')
            ->skip($request->firstPage)
            ->take($request->lastPage)
            ->where('namaPasien','like',"%$request->searchNamaPasien%")
            ->where('tanggal', $tglSearch)
            ->get();
            $totalDataPasien = Pasien::where('namaPasien','like',"%$request->searchNamaPasien%")
            ->where('tanggal', $tglSearch)
            ->count();
        }else{
            $dataPasien = Pasien::orderBy('tanggal', 'desc')
            ->skip($request->firstPage)
            ->take($request->lastPage)
            ->where('namaPasien','like',"%$request->searchNamaPasien%")
            ->get();
            $totalDataPasien = Pasien::where('namaPasien','like',"%$request->searchNamaPasien%")->count();
        }
        
        return response()->json([
            'dataPasien' => $dataPasien,
            'totalDataPasien' => $totalDataPasien
        ], 200);
    }

    public function deleteDataPasienPulang($idPasien){
        $dataPasien = Pasien::where('idPasien', $idPasien)->first();
        $status = "Data Pasien $dataPasien->namaPasien Berhasil Dihapus!";
        RecordLog::logRecord('DELETE', $dataPasien->idPasien, $dataPasien, null, null);
        $dataPasien->delete();
       
        return response()->json([
            'status' => $status
        ], 200);
    }

    public function saveDataPasienPulang(Request $request){
        $tanggal = $this->convertDate($request->tanggal);
        $dataPasien = Pasien::where('noReg', $request->noReg)->first();

        if($dataPasien){
            $status = "Data No Registrasi $dataPasien->noReg Sudah Pernah Tersimpan!";
            return response()->json([
                'status' => $status
            ], 403);
        }else{
            $dataPasien = new Pasien;
            $dataPasien->idPasien = $dataPasien->getIDPasien();
            $dataPasien->noReg = $request->noReg;
            $dataPasien->tanggal = $tanggal;
            $dataPasien->nrm = $request->nrm;
            $dataPasien->namaPasien = $request->namaPasien;
            $dataPasien->kamar = $request->kamar;
            $dataPasien->isTerencana = $request->isTerencana;
            $dataPasien->noKartu = $request->noKartu;
            $dataPasien->keterangan = $request->keterangan;
            $dataPasien->idUser = null;
            $dataPasien->waktuVerif = null;
            $dataPasien->waktuIKS = null;
            $dataPasien->waktuSelesai = null;
            $dataPasien->waktuPasien = null;
            $dataPasien->waktuLunas = null;
            $dataPasien->petugasFO = null;
            $dataPasien->petugasPerawat = null;
            $dataPasien->isEdit = false;
            
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
            RecordLog::logRecord('INSERT', $dataPasien->idPasien, null, $dataPasien, null);
            $status = "Data Pasien $dataPasien->namaPasien Berhasil Disimpan!";
            return response()->json([
                'status' => $status,
                'dataPasien' => $dataPasien
            ], 200);
        }
    }
    
    public function updateDataPasienPulang(Request $request){
        $pasienPulang = Pasien::where('idPasien', $request->idPasien)->first();
        $pasienDataOld = $pasienPulang->replicate();
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
            $pasienPulang->isTerencana = $request->isTerencana;
            $pasienPulang->save();
            RecordLog::logRecord('UPDATE', $pasienPulang->idPasien, $pasienDataOld, $pasienPulang, null);
            $status = "Data Pasien $pasienPulang->namaPasien Berhasil DiUpdate!";
            return response()->json([
                'status' => $status,
                'dataPasien' => $pasienPulang
            ], 200);
        }
        $status = "Data Pasien Gagal DiUpdate!";
        return response()->json([
            'status' => $status
        ], 500);
    }

    public function convertDate($date){
        return date('Y-m-d H:i:s', strtotime($date));
    }


    public function autoGetPasien(){
        $jasaSC = ['JAS00011', 'JAS00012','JAS01231','JAS01232', 'JAS01484'];
        $jasaNormal = ['JAS00008'];

        $listRegistrasiSCFromRegistrasi = $this->autoGetPasienFromRegistrasi($jasaSC);
        $listRegistrasiNormalFromRegistrasi = $this->autoGetPasienFromRegistrasi($jasaNormal);
        
        $listRegistrasiSCFromKasir = $this->autoGetPasienFromKasir($jasaSC);
        $listRegistrasiNormalSCFromKasir = $this->autoGetPasienFromKasir($jasaNormal);
        
        $dataNoRegPasienSCs = collect();
        $dataNoRegPasienSCs = $dataNoRegPasienSCs->concat($listRegistrasiSCFromRegistrasi)->concat($listRegistrasiSCFromKasir);

        $dataNoRegPasienNormals = collect();
        $dataNoRegPasienNormals = $dataNoRegPasienNormals->concat($listRegistrasiNormalFromRegistrasi)->concat($listRegistrasiNormalSCFromKasir);
        $this->autoSaveDataPasien($dataNoRegPasienSCs,2);
        $this->autoSaveDataPasien($dataNoRegPasienNormals,1);
    }
    
    public function autoGetPasienFromRegistrasi($jasaID){
        $sanataRegistrasi = \DB::connection('sqlsrv')
            ->table('SIMtrRJ')
            ->selectRaw('SIMtrRJ.RegNo as noReg, SIMtrRJ.Tanggal as tanggal, SIMtrRegistrasi.NRM as nrm, SIMtrRegistrasi.NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoKamar as kamar, SIMtrRegistrasi.NoAnggota as noKartu, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, SIMtrRegistrasi.BPJSMurni as BPJSMurni, SIMtrRegistrasi.SilverPlus as silverPlus, SIMtrRegistrasi.NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
            ->join('SIMtrRJTransaksi', 'SIMtrRJ.NoBukti', 'SIMtrRJTransaksi.NoBukti')
            ->join('SIMtrRegistrasi', 'SIMtrRJ.RegNo', 'SIMtrRegistrasi.NoReg')
            ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
            ->join('mCustomer', 'mCustomer.Kode_Customer', 'SIMtrRegistrasi.KodePerusahaan')
            ->whereIn('SIMtrRJ.RegNo', function($query) {
                    $query->select('NoReg')->from('SIMtrRegistrasi')->where('Batal', 0)->where('RawatInap',1)->where('StatusBayar', 'Belum');
                })
            ->whereIn('SIMtrRJTransaksi.JasaID', $jasaID)
            ->get();
        return $sanataRegistrasi;
    }

    public function autoGetPasienFromKasir($jasaID){
        $tanggalSekarang = \Carbon\Carbon::now()->toDateString();
        $tanggalKemarin = \Carbon\Carbon::now()->subDays(1)->toDateString();
        $sanataKasir = \DB::connection('sqlsrv')
            ->table('SIMtrRJ')
            ->selectRaw('SIMtrRJ.RegNo as noReg, SIMtrRJ.Tanggal as tanggal, SIMtrRegistrasi.NRM as nrm, SIMtrRegistrasi.NamaPasien_Reg as namaPasien, SIMtrRegistrasi.NoKamar as kamar, SIMtrRegistrasi.NoAnggota as noKartu, SIMmJenisKerjasama.JenisKerjasama as jenisKerjasama, SIMtrRegistrasi.BPJSMurni as BPJSMurni, SIMtrRegistrasi.SilverPlus as silverPlus, SIMtrRegistrasi.NaikKelas as naikKelas, mCustomer.Nama_Customer as namaPerusahaan')
            ->join('SIMtrRJTransaksi', 'SIMtrRJ.NoBukti', 'SIMtrRJTransaksi.NoBukti')
            ->join('SIMtrRegistrasi', 'SIMtrRJ.RegNo', 'SIMtrRegistrasi.NoReg')
            ->join('SIMmJenisKerjasama', 'SIMmJenisKerjasama.JenisKerjasamaID', 'SIMtrRegistrasi.JenisKerjasamaID')
            ->join('mCustomer', 'mCustomer.Kode_Customer', 'SIMtrRegistrasi.KodePerusahaan')
            ->whereIn('SIMtrRJ.RegNo', function($query) use ($tanggalSekarang, $tanggalKemarin) {
                    $query->select('NoReg')->from('SIMtrKasir')
                    ->where('Batal', 0)
                    ->where('RJ','RI')
                    ->where('Tanggal','>=', $tanggalKemarin)
                    ->where('Tanggal','<=', $tanggalSekarang);
                })
            ->whereIn('SIMtrRJTransaksi.JasaID', $jasaID)
            ->get();
        return $sanataKasir;
    }
    public function autoSaveDataPasien($dataPasienCollection, $jumlahHari){
        foreach($dataPasienCollection as $dataPasien){
            $pasien = Pasien::where('noReg', $dataPasien->noReg)->first();
            if($pasien){
                continue;
            }

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

            $pasien = new Pasien;
            $pasien->idPasien = $pasien->getIDPasien();
            $pasien->noReg = $dataPasien->noReg;
            $pasien->tanggal = \Carbon\Carbon::parse($dataPasien->tanggal)->addDays($jumlahHari);
            $pasien->nrm = $dataPasien->nrm;
            $pasien->namaPasien = $dataPasien->namaPasien;
            $pasien->kamar = $dataPasien->kamar;
            $pasien->keterangan = $dataPasien->keterangan;
            $pasien->isTerencana = true;
            $pasien->noKartu = $dataPasien->noKartu;
            $pasien->idUser = 'SYSTEM';
            $pasien->waktuVerif = null;
            $pasien->waktuIKS = null;
            $pasien->waktuSelesai = null;
            $pasien->waktuPasien = null;
            $pasien->waktuLunas = null;
            $pasien->petugasFO = null;
            $pasien->petugasPerawat = null;
            $pasien->isEdit = false;
            $pasien->save();
            RecordLog::logRecord('INSERT', $pasien->idPasien, null, $pasien, 'SYSTEM');
        }
    }
    public function getDataExportPasienPulang(Request $request){
        $tglAwal = $this->convertDate($request->awal);
        $tglAkhir = $this->convertDate($request->akhir);
        $dataPasien = Pasien::where('tanggal', '>=', $tglAwal)
            ->where('tanggal', '<=', $tglAkhir)
            ->orderBy('created_at','asc')
            ->get();
        RecordLog::logRecord('REPORT', null, $tglAwal, $tglAkhir, null);
        $status = "Data Terkonversi ke Excel";
        return response()->json([
            'status' => $status,
            'dataPasien' => $dataPasien
        ], 200);
    }
}
