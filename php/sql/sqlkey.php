<?php
require_once('sqltable.php');

class KeySql extends TableSql
{
	var $strKey;
	
    function KeySql($strTableName, $strKeyPrefix = TABLE_PAGE) 
    {
    	$this->strKey = $this->Add_id($strKeyPrefix);
        parent::TableSql($strTableName);
    }
    
    function GetKeyIndex()
    {
    	return $this->strKey;
    }
    
    function ComposeKeyStr()
    {
    	return $this->ComposeIdStr($this->strKey);
    }

    function ComposeForeignKeyStr()
    {
		return $this->ComposeForeignStr($this->strKey);
    }
    
    function GetKeyId($strId)
    {
   		if ($record = $this->GetRecordById($strId))
   		{
   			return $record[$this->strKey];
   		}
   		return false;
    }
    
    function MakeFieldKeyId($strKeyId)
    {
    	return array($this->strKey => $strKeyId);
    }
    
    function BuildWhere_key_ex($strKeyId, $strExId, $strExVal)
    {
    	$ar = $this->MakeFieldKeyId($strKeyId);
    	$ar[$strExId] = $strExVal;
		return _SqlBuildWhereAndArray($ar);
    }
    
    function BuildWhere_key($strKeyId)
    {
    	return _SqlBuildWhere($this->strKey, $strKeyId);
    }

    function Count($strKeyId)
    {
    	return $this->CountData($this->BuildWhere_key($strKeyId));
    }

    public function BuildOrderBy()
    {
    	return false;
    }
    
    public function GetAll($strKeyId = false, $iStart = 0, $iNum = 0)
    {
   		return $this->GetData($this->BuildWhere_key($strKeyId), $this->BuildOrderBy(), _SqlBuildLimit($iStart, $iNum));
    }

    function GetRecordNow($strKeyId = false, $strDummy = false)
    {
    	return $this->GetSingleData($this->BuildWhere_key($strKeyId), $this->BuildOrderBy());
    }
    
    function DeleteAll($strKeyId)
    {
    	if ($strKeyId !== false)
    	{
    		return $this->DeleteData($this->BuildWhere_key($strKeyId));
    	}
    	return false;
    }
}

?>
