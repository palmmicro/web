<?php
require_once('sqltable.php');

class KeyNameSql extends TableSql
{
	var $strKey;
	var $strKeyId = false;
	var $strKeyName;
	
    function KeyNameSql($strTableName, $strKeyName = 'parameter', $strKey = false)
    {
        $this->strKey = $strKey;
        $this->strKeyName = $strKeyName;
        parent::TableSql($strTableName);
/*       
    	$ar = $this->GetTableColumnName();
//    	DebugArray($ar);
    	if ($ar[1] != $strKeyName)
    	{
    		$this->strKeyName = $ar[1];
//    		DebugString($this->strKeyName.' vs '.$strKeyName);
    	}*/
    }

    function MakeKeyArray()
    {
    	return array($this->strKeyName => $this->strKey);
    }
    
    function MakeInsertArray()
    {
    	return $this->MakeKeyArray();
    }
    
    function InsertKey()
    {
   		if ($this->strKey)
   		{
   			$this->strKeyId = $this->GetId($this->strKey);
   			if ($this->strKeyId == false)
   			{
   				if ($this->InsertArray($this->MakeInsertArray()))
   				{
//  					DebugString('New key: '.$this->strKey);
   					$this->strKeyId = $this->GetId($this->strKey);
   				}
   			}
   		}
    }
    
    function CreateKeyNameTable($str)
    {
    	if ($b = $this->CreateIdTable($str))
    	{
    		$this->InsertKey();
    	}
    	return $b;
    }
    
    function Create()
    {
    	$str = ' `'.$this->strKeyName.'` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	. ' FULLTEXT ( `'.$this->strKeyName.'` )';
        return $this->CreateKeyNameTable($str);
    }

    function GetKeyId()
    {
    	return $this->strKeyId;
    }
    
    function GetKey($strId = false)
    {
    	if ($strId)
    	{
    		if ($record = $this->GetRecordById($strId))
    		{
    			return $record[$this->strKeyName];
    		}
    		return false;
    	}
    	return $this->strKey;
    }

    function GetRecord($strKey = false)
    {
    	return $strKey ? $this->GetSingleData(_SqlBuildWhere($this->strKeyName, $strKey)) : $this->GetRecordById($this->GetKeyId());
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`'.$this->strKeyName.'` ASC', _SqlBuildLimit($iStart, $iNum));
    }
}

?>
