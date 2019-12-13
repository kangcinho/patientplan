<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = "pasien";
    protected $fillable = ['idPasien','noreg', 'tanggal', 'nrm', 'namaPasien', 'kamar', 'waktuVerif', 'waktuIKS', 'waktuSelesai', 'waktuPasien', 'waktuLunas', 'petugasFO', 'petugasPerawat', 'keterangan', 'idUser', 'isGone', 'isAnalisa', 'mutuUmum', 'mutuIKS', 'mutuBPJS' ];
    public $incrementing = false;
    protected $primaryKey = 'idPasien';
    protected $casts = [
        'isEdit' => 'boolean',
    ];
    public function getIDPasien(){
        $tanggal = Date('ymd');
        $time = microtime(true) * 1000;
        // $time = substr($time, -8,6);
        return  $tanggal.'PSN-'.$time;
    }
}
