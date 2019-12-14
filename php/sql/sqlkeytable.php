<?php
require_once('sqltable.php');

class KeyTableSql extends TableSql
{
	var $strKey;
	var $strKeyPrefix;
	var $strKeyId;
	
    function KeyTableSql($strTableName, $strKeyId, $strKeyPrefix) 
    {
    	$this->strKeyId = $strKeyId;
    	$this->strKeyPrefix = $strKeyPrefix;
    	$this->strKey = $strKeyPrefix.'_id';
        parent::TableSql($strTableName);
    }
    
    function ComposeKeyStr()
    {
    	return ' `'.$this->strKey.'` INT UNSIGNED NOT NULL ';
    }

    function ComposeForeignKeyStr()
    {
		return ' FOREIGN KEY (`'.$this->strKey.'`) REFERENCES `'.$this->strKeyPrefix.'`(`id`) ON DELETE CASCADE ';
    }
    
    function MakeFieldKeyId()
    {
    	return array($this->strKey => $this->strKeyId);
    }
    
    function BuildWhere_key()
    {
    	return _SqlBuildWhere($this->strKey, $this->strKeyId);
    }
    
    function BuildWhere_key_extra($strKey, $strVal)
    {
    	$ar = $this->MakeFieldKeyId();
    	$ar[$strKey] = $strVal;
		return _SqlBuildWhereAndArray($ar);
    }
    
    function BuildWhere_key_stock($strStockId)
    {
		return $this->BuildWhere_key_extra('stock_id', $strStockId);
    }
    
    function GetKeyId($strId = false)
    {
    	if ($strId)
    	{
    		if ($record = $this->GetRecordById($strId))
    		{
    			return $record[$this->strKey];
    		}
    		return false;
    	}
    	return $this->strKeyId;
    }
    
    function Count()
    {
    	return $this->CountData($this->BuildWhere_key());
    }
    
    function GetAll()
    {
    	return $this->GetData($this->BuildWhere_key());
    }

    function DeleteAll()
    {
    	return $this->DeleteData($this->BuildWhere_key());
    }
}

?>
