<?php
require_once('sqldailyclose.php');

class DailyTimeSql extends DailyCloseSql
{
    function DailyTimeSql($strTableName, $strKeyPrefix = TABLE_STOCK) 
    {
        parent::DailyCloseSql($strTableName, $strKeyPrefix);
    }

    public function Create()
    {
        return $this->CreateDailyKeyTable($this->ComposeCloseStr().','.$this->ComposeTimeStr());
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
}

class FundEstSql extends DailyTimeSql
{
    function FundEstSql() 
    {
        parent::DailyTimeSql(TABLE_FUND_EST);
    }
}

?>
