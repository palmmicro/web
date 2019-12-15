<?php
require_once('sqltable.php');

class KeyNameSql extends TableSql
{
	var $strKeyName;
	
    function KeyNameSql($strTableName, $strKeyName = 'parameter')
    {
        $this->strKeyName = $strKeyName;
        parent::TableSql($strTableName);
        
    	$ar = $this->GetTableColumn();
//    	DebugArray($ar);
    	if ($ar[1] != $strKeyName)
    	{
    		$this->strKeyName = $ar[1];
//    		DebugString($this->strKeyName.' vs '.$strKeyName);
    	}
    }

    function Create()
    {
    	$str = ' `'.$this->strKeyName.'` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' UNIQUE ( `'.$this->strKeyName.'` (255) )';
    	return $this->CreateIdTable($str);
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`'.$this->strKeyName.'` ASC', _SqlBuildLimit($iStart, $iNum));
    }

    function GetKey($strId)
    {
    	if ($record = $this->GetRecordById($strId))
    	{
    		return $record[$this->strKeyName];
    	}
    	return false;
    }

    function GetRecord($strKey)
    {
    	return $this->GetSingleData(_SqlBuildWhere($this->strKeyName, $strKey));
    }

    function InsertKey($strKey)
    {
    	if ($this->GetRecord($strKey) == false)
    	{
    		return $this->InsertData(array($this->strKeyName => $strKey));
    	}
    	return false;
    }
}

?>
