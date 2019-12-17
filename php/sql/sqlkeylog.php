<?php
require_once('sqlkeytable.php');

class KeyLogSql extends KeyTableSql
{
	var $log_sql;

	var $strLog;
	
    function KeyLogSql($strTableName, $strKey, $strKeyPrefix, $strLogPrefix = 'log')
    {
    	$this->log_sql = new KeyNameSql($strLogPrefix);
    	
    	$this->strLog = $strLogPrefix.'_id';
        parent::KeyTableSql($strTableName, false, $strKeyPrefix);
        
        // temp op, move to KeyTableSql later
		$this->SetKeyVal($strKey);
    }

    function Create()
    {
    	$str = ' `'.$this->strLog.'` INT UNSIGNED NOT NULL ,'
    		  . $this->ComposeKeyStr().','
    		  . ' `date` DATE NOT NULL ,'
    		  . ' `time` TIME NOT NULL ,'
    		  . ' FOREIGN KEY (`'.$this->strLog.'`) REFERENCES `'.$this->log_sql->GetTableName().'`(`id`) ON DELETE CASCADE ,'
         	  . $this->ComposeForeignKeyStr();
    	return $this->CreateIdTable($str);
    }
    
    function GetLogSql()
    {
    	return $this->log_sql;
    }
    
    function BuildOrderBy()
    {
    	return _SqlOrderByDateTime();
    }
    
    function InsertLog($strLog)
    {
    	$ar = $this->MakeFieldKeyId();
    	$ar[$this->strLog] = $this->log_sql->GetId($strLog);
    	$ar['date'] = DebugGetDate();
	    $ar['time'] = DebugGetTime();
    	return $this->InsertData($ar);
    }
}

?>
