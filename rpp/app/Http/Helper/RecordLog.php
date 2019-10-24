<?php namespace App\Http\Helper;
use App\Log;

class RecordLog{

 	public static function logRecord($action, $idBukti, $valueBefore, $valueAfter, $userID){
    $log = new Log();
    $log->idLog = $log->getIDLog();
    $log->idBukti =$idBukti;
    $log->idUser = $userID;
    $log->action = $action;
    $log->valueBefore = $valueBefore;
    $log->valueAfter = $valueAfter;
    $log->save();
  }
}
