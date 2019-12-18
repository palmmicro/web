<?php
require_once('sqltable.php');

class KeyNameSql extends TableSql
{
	var $strKey;
	var $strKeyId = false;
	var $strKeyName;
	
    function KeyNameSql($strTableName, $strKey = false, $strKeyName = 'parameter')
    {
        $this->strKey = $strKey;
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

    function InsertKey()
    {
   		if ($this->strKey)
   		{
   			$this->strKeyId = $this->GetId($this->strKey);
   			if ($this->strKeyId == false)
   			{
   				if ($this->InsertData(array($this->strKeyName => $this->strKey)))
   				{
   					DebugString('New key: '.$this->strKey);
   					$this->strKeyId = $this->GetId($this->strKey);
   				}
   			}
   		}
    }
    
    function Create()
    {
    	$str = ' `'.$this->strKeyName.'` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	. ' FULLTEXT ( `'.$this->strKeyName.'` )';
    	if ($b = $this->CreateIdTable($str))
    	{
    		$this->InsertKey();
    	}
    	return $b;
    }

    function GetKeyId()
    {
    	return $this->strKeyId;
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

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`'.$this->strKeyName.'` ASC', _SqlBuildLimit($iStart, $iNum));
    }
}

?>
