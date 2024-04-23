<?php
require_once('sqldailyclose.php');

class DailyTimeSql extends DailyCloseSql
{
    public function __construct($strTableName, $strKeyPrefix = 'stock') 
    {
        parent::__construct($strTableName, $strKeyPrefix);
    }

    public function Create()
    {
        return $this->CreateDailyCloseTable($this->ComposeCloseStr().','.$this->ComposeTimeStr());
    }

    public function InsertDaily($strKeyId, $strDate, $strClose)
    {
        if ($this->GetRecord($strKeyId, $strDate))			return false;
        
        $ar = $this->MakeFieldArray($strKeyId, $strDate, $strClose);
   		$ar['time'] = DebugGetTime();
    	return $this->InsertArray($ar);
    }

    public function UpdateDaily($strId, $strClose)
    {
        $strTime = DebugGetTime();
		return $this->UpdateById(array('close' => $strClose, 'time' => $strTime), $strId);
    }
/*
    function GetTimeNow($strKeyId = false)
    {
    	if ($record = $this->GetRecordNow($strKeyId))
    	{
    		return $record['time'];
    	}
    	return false;
    }
*/    
}

class FundEstSql extends DailyTimeSql
{
    public function __construct() 
    {
        parent::__construct('fundest');
    }
}

class CalibrationSql extends DailyTimeSql
{
    public function __construct() 
    {
        parent::__construct('calibrationhistory');
    }
}

?>
