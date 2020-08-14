<?php
require_once('sqlkeyname.php');

class KeyTableSql extends TableSql
{
//	var $key_sql;
	
	var $strKey;
	var $strKeyPrefix;
	var $strKeyId;
	
    function KeyTableSql($strTableName, $strKeyId, $strKeyPrefix) 
    {
//    	$this->key_sql = new KeyNameSql($strKeyPrefix);
    	
    	$this->strKeyId = $strKeyId;
    	$this->strKeyPrefix = $strKeyPrefix;
    	$this->strKey = $strKeyPrefix.'_id';
        parent::TableSql($strTableName);
    }
/*    
    function SetKeyVal($strVal)
    {
		$this->strKeyId = $this->key_sql->GetId($strVal);
    }
    
    function GetKeySql()
    {
    	return $this->key_sql;
    }*/
    
    function ComposeKeyStr()
    {
    	return ' `'.$this->strKey.'` INT UNSIGNED NOT NULL ';
    }

    function ComposeForeignKeyStr()
    {
		return ' FOREIGN KEY (`'.$this->strKey.'`) REFERENCES `'.$this->strKeyPrefix.'`(`id`) ON DELETE CASCADE ';
//		return ' FOREIGN KEY (`'.$this->strKey.'`) REFERENCES `'.$this->key_sql->GetTableName().'`(`id`) ON DELETE CASCADE ';
    }
    
    function MakeFieldKeyId()
    {
    	return array($this->strKey => $this->strKeyId);
    }
    
    function BuildOrderBy()
    {
    	return false;
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

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData($this->BuildWhere_key(), $this->BuildOrderBy(), _SqlBuildLimit($iStart, $iNum));
    }

    function GetRecordNow($strDummy = false)
    {
    	return $this->GetSingleData($this->BuildWhere_key(), $this->BuildOrderBy());
    }
    
    function DeleteAll()
    {
    	if ($this->strKeyId !== false)
    	{
    		return $this->DeleteRecord($this->BuildWhere_key());
    	}
    	return false;
    }
}

?>
