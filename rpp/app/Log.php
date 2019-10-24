<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log";
    protected $fillable = ['idLog','idUser', 'action', 'idPasien', 'valueBefore', 'valueAfter'];
    public $incrementing = false;
    protected $primaryKey = 'idLog';

    public function getIDLog(){
        $tanggal = Date('ymd');
        $time = microtime(true) * 1000;
        // $time = substr($time, -8,6);
        return  $tanggal.'LOG-'.$time;
    }
}
