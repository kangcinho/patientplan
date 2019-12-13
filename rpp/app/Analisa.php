<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisa extends Model
{
    protected $table = "analisa";
    protected $fillable = ['analisaID','tanggal','umumMutuValid','umumMutuNonValid','iksMutuValid','iksMutuNonValid','bpjsMutuValid','bpjsMutuNonValid'];
    public $incrementing = false;
    protected $primaryKey = 'analisaID';
    public function getIDAnalisa(){
        $tanggal = Date('ymd');
        $time = microtime(true) * 1000;
        // $time = substr($time, -8,6);
        return  $tanggal.'Analisa-'.$time;
    }
}
