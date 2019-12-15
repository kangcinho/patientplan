<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mutu;
use App\Pasien;
use App\Analisa;
use App\Http\Helper\HelperTanggal;
use DateTime;
class AnalisaController extends Controller
{
    public function showAnalisa(Request $request){
        $bulanPilih = $this->convertDate($request->bulanAnalisa);
        $bulanNow = explode('-', $bulanPilih)[1];
        if($bulanNow == 1 || $bulanNow == '01'){
            $bulanBefore = 12;
        }else{
            $bulanBefore = $bulanNow - 1;
        }
        $tahunNow = explode('-', $bulanPilih)[0];
        $tahunBefore = $tahunNow - 1;
        
        $analisaBulanNow = $this->getDataAnalisa($bulanNow, $tahunNow);
        $analisaBulanBefore = $this->getDataAnalisa($bulanBefore, $tahunNow);
        $analisaTahunBefore = $this->getDataAnalisa($bulanNow, $tahunBefore);

        $tableAnalisaBulanNow = $this->tabelPerbandinganAnalisa($analisaBulanNow);
        $tableAnalisaBulanBefore = $this->tabelPerbandinganAnalisa($analisaBulanBefore);
        $tableAnalisaTahunBefore = $this->tabelPerbandinganAnalisa($analisaTahunBefore);

        return response()->json([
            'tabelAnalisa' => $this->mergeObject($tableAnalisaBulanNow, $tableAnalisaBulanBefore, $tableAnalisaTahunBefore),
            'status' => "Data Analisa"
        ]);
    }
    private function mergeObject($tableAnalisaBulanNow, $tableAnalisaBulanBefore, $tableAnalisaTahunBefore){
        $tabelAnalisa = array();
        array_push($tabelAnalisa, $tableAnalisaBulanNow);
        array_push($tabelAnalisa, $tableAnalisaBulanBefore);
        array_push($tabelAnalisa, $tableAnalisaTahunBefore);
        return $tabelAnalisa;
    }
    private function getDataAnalisa($bulan, $tahun){
        $analisa = \DB::table('analisa')
        ->selectRaw("tanggal, umumMutuValid, umumMutuNonValid, (umumMutuValid + umumMutuNonValid) as umumMutu, iksMutuValid, iksMutuNonValid, (iksMutuValid + iksMutuNonValid) as iksMutu, bpjsMutuValid, bpjsMutuNonValid, (bpjsMutuValid + bpjsMutuNonValid) as bpjsMutu")
        ->whereYear("tanggal", $tahun)
        ->whereMonth("tanggal", $bulan)
        ->orderBy("tanggal")
        ->get();
        return $analisa;
    }

    private function tabelPerbandinganAnalisa($dataAnalisa){
        $tanggal = new HelperTanggal;
        $analisaTable = new \stdClass;
        $analisaTable->tanggal = null;
        $analisaTable->umumMutuValid = 0;
        $analisaTable->umumMutuNonValid = 0;
        $analisaTable->umumMutu = 0;
        $analisaTable->iksMutuValid = 0;
        $analisaTable->iksMutuNonValid = 0;
        $analisaTable->iksMutu = 0;
        $analisaTable->bpjsMutuValid = 0;
        $analisaTable->bpjsMutuNonValid = 0;
        $analisaTable->bpjsMutu = 0;
        
        foreach($dataAnalisa as $analisa){
            $analisaTable->tanggal = $tanggal->tanggalBacaBulanTahun($analisa->tanggal);
            $analisaTable->umumMutuValid += $analisa->umumMutuValid;
            $analisaTable->umumMutuNonValid += $analisa->umumMutuNonValid;
            $analisaTable->umumMutu += $analisa->umumMutu;
            $analisaTable->iksMutuValid += $analisa->iksMutuValid;
            $analisaTable->iksMutuNonValid += $analisa->iksMutuNonValid;
            $analisaTable->iksMutu += $analisa->iksMutu;
            $analisaTable->bpjsMutuValid += $analisa->bpjsMutuValid;
            $analisaTable->bpjsMutuNonValid += $analisa->bpjsMutuNonValid;
            $analisaTable->bpjsMutu += $analisa->bpjsMutu;
        }
        return $analisaTable;
    }

    public function setIsGone(){
        $dateToday = \Carbon\Carbon::now()->toDateString();
        \DB::statement("UPDATE pasien set isGone = 1 WHERE tanggal < '$dateToday'");
    }
    public function doAnalisa(){
        $dataMutu = Mutu::where('isAktif', 1)->first();
        $dataPasiens = Pasien::where('isAnalisa', 0)->where('isGone', 1)->get();
        $dataPasiens = $this->hitungWaktu($dataPasiens);
        $dataPasiens = $this->groupingData($dataPasiens);
        $recordData = array();
        
        foreach($dataPasiens as $dataPasien){
            $bpjsMutuValid = 0;
            $bpjsMutuNonValid = 0;
            $iksMutuValid = 0;
            $iksMutuNonValid = 0;
            $umumMutuValid = 0;
            $umumMutuNonValid = 0;
            foreach($dataPasien->mutuPasien as $mutuPasien){
                if($mutuPasien->waktuTotal == 0){
                    continue;
                }
                if (strpos($mutuPasien->keterangan, 'BPJS') !== false) {
                    if($mutuPasien->waktuTotal > $dataMutu->mutuBPJS ){
                        $bpjsMutuNonValid++;
                    }else{
                        $bpjsMutuValid++;
                    }
                }else if(strpos($mutuPasien->keterangan, 'IKS') !== false) {
                    if($mutuPasien->waktuTotal > $dataMutu->mutuIKS ){
                        $iksMutuNonValid++;
                    }else{
                        $iksMutuValid++;
                    }
                }else if(strpos($mutuPasien->keterangan, 'Umum') !== false) {
                    if($mutuPasien->waktuTotal > $dataMutu->mutuUmum ){
                        $umumMutuNonValid++;
                    }else{
                        $umumMutuValid++;
                    }
                }
            }
            $recordDataDetail = new \stdClass;
            $recordDataDetail->tanggal = $dataPasien->tanggal;
            $recordDataDetail->umumMutuValid = $umumMutuValid;
            $recordDataDetail->umumMutuNonValid = $umumMutuNonValid;
            $recordDataDetail->iksMutuValid = $iksMutuValid;
            $recordDataDetail->iksMutuNonValid = $iksMutuNonValid;
            $recordDataDetail->bpjsMutuValid = $bpjsMutuValid;
            $recordDataDetail->bpjsMutuNonValid = $bpjsMutuNonValid;
            array_push($recordData, $recordDataDetail);
        }
        foreach($recordData as $data){
            $dataAnalisa = Analisa::where('tanggal', $data->tanggal)->first();
            if($dataAnalisa){
                $dataAnalisa->umumMutuValid = $data->umumMutuValid;
                $dataAnalisa->umumMutuNonValid = $data->umumMutuNonValid;
                $dataAnalisa->iksMutuValid = $data->iksMutuValid;
                $dataAnalisa->iksMutuNonValid = $data->iksMutuNonValid;
                $dataAnalisa->bpjsMutuValid = $data->bpjsMutuValid;
                $dataAnalisa->bpjsMutuNonValid = $data->bpjsMutuNonValid;
                $dataAnalisa->save();
            }else{
                $dataAnalisa = new Analisa;
                $dataAnalisa->analisaID = $dataAnalisa->getIDAnalisa();
                $dataAnalisa->tanggal = $data->tanggal;
                $dataAnalisa->umumMutuValid = $data->umumMutuValid;
                $dataAnalisa->umumMutuNonValid = $data->umumMutuNonValid;
                $dataAnalisa->iksMutuValid = $data->iksMutuValid;
                $dataAnalisa->iksMutuNonValid = $data->iksMutuNonValid;
                $dataAnalisa->bpjsMutuValid = $data->bpjsMutuValid;
                $dataAnalisa->bpjsMutuNonValid = $data->bpjsMutuNonValid;
                $dataAnalisa->save();
            }
        }
        \DB::statement("UPDATE pasien set isAnalisa = 1 WHERE isGone = 1");
        // return response()->json([
        //     'result' => $recordData,
        // ]);
    }

    private function hitungWaktu($dataPasien){
        foreach($dataPasien as $pasien){
            if($pasien->waktuVerif == null OR $pasien->waktuVerif == ''){
                $pasien->waktuTotal =  0;
                continue;
            }
            // if($pasien->waktuIKS == null OR $pasien->waktuIKS == ''){
            //     $pasien->waktuTotal =  0;
            //     continue;
            // }
            // if($pasien->waktuSelesai == null OR $pasien->waktuSelesai == ''){
            //     $pasien->waktuTotal =  0;
            //     continue;
            // }
            // if($pasien->waktuPasien == null OR $pasien->waktuPasien == ''){
            //     $pasien->waktuTotal =  0;
            //     continue;
            // }
            if($pasien->waktuLunas == null OR $pasien->waktuLunas == ''){
                $pasien->waktuTotal =  0;
                continue;
            }
            $waktuVerif = new DateTime($pasien->waktuVerif);
            $waktuLunas = new DateTime($pasien->waktuLunas);
            $hitungWaktu = $waktuLunas->diff($waktuVerif);
            $pasien->waktuTotal = $hitungWaktu->days * 24 * 60;
            $pasien->waktuTotal += $hitungWaktu->h * 60;
            $pasien->waktuTotal += $hitungWaktu->i;
        }
        return $dataPasien;
    }

    private function groupingData($dataPasien){
        $dataGroupPasien = [];
        foreach($dataPasien as $pasien){
            if($this->ifDateExist($dataGroupPasien, $pasien)){
                $dataGroupPasien = $this->insertMutuPasien($dataGroupPasien, $pasien);
            }else{
                $pasien = $this->createMutuPasien($pasien);
                array_push($dataGroupPasien, $pasien);
            }
        }
        return $dataGroupPasien;
    }

    private function ifDateExist($dataGroupPasien, $pasien){

        foreach($dataGroupPasien as $dataGroup){
            if($dataGroup->tanggal === $pasien->tanggal){
                return true;
            }
        }
        return false;
    }

    private function insertMutuPasien($dataGroupPasien, $pasien){
        foreach($dataGroupPasien as $dataGroup){
            if($dataGroup->tanggal == $pasien->tanggal){
                $dataPasien = $this->dataPasien($pasien);
                array_push($dataGroup->mutuPasien, $dataPasien);
            }
        }
        return $dataGroupPasien;
    }
    private function dataPasien($pasien){
        $dataPasien = new \stdClass;
        $dataPasien->keterangan = $pasien->keterangan;
        $dataPasien->waktuTotal = $pasien->waktuTotal;

        return $dataPasien;
    }
    
    private function createMutuPasien($pasien){
        $dataPasien = new \stdClass;
        $mutuPasien = array();
        $dataPasien->tanggal = $pasien->tanggal;
        $dataMutuPasien = $this->dataPasien($pasien);
        array_push($mutuPasien, $dataMutuPasien);

        $dataPasien->mutuPasien = $mutuPasien;
        return $dataPasien;
    }

    private function convertDate($date){
        return date('Y-m-d', strtotime($date));
    }
}
