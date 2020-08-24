<?php
require_once('sqltable.php');

class KeyNameSql extends TableSql
{
	var $strKeyName;
	
    function KeyNameSql($strTableName, $strKeyName = 'parameter')
    {
        $this->strKeyName = $strKeyName;
        parent::TableSql($strTableName);
    }

    function InsertKey($strKey)
    {
		if ($this->GetRecord($strKey) == false)
		{
			return $this->InsertArray(array($this->strKeyName => $strKey));
   		}
   		return false;
    }
    
    public function Create()
    {
    	$str = ' `'.$this->strKeyName.'` VARCHAR( 128 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	  . ' UNIQUE ( `'.$this->strKeyName.'` )';
        return $this->CreateIdTable($str);
    }
    
    function GetKey($strId)
    {
   		if ($record = $this->GetRecordById($strId))
   		{
   			return $record[$this->strKeyName];
   		}
   		return false;
    }

    public function GetRecord($strKey)
    {
    	return $this->GetSingleData(_SqlBuildWhere($this->strKeyName, $strKey));
    }

    public function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`'.$this->strKeyName.'` ASC', _SqlBuildLimit($iStart, $iNum));
    }
}

?>
