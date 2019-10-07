<?php namespace App\Http\Helper;
use App\Log;

class RecordLog{

 	public static function logRecord($action, $idBukti, $valueBefore, $valueAfter){
    $log = new Log();
    $log->idLog = $log->getIDLog();
    $log->idBukti =$idBukti;
    $log->idUser = null;
    $log->action = $action;
    $log->valueBefore = $valueBefore;
    $log->valueAfter = $valueAfter;
    $log->save();
  }
}
