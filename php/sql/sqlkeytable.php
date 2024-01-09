<?php
require_once('sqlkeyname.php');

class KeyTableSql extends TableSql
{
	var $strKey;
	var $strKeyId;
	
    public function __construct($strTableName, $strKeyId, $strKeyPrefix) 
    {
    	$this->strKeyId = $strKeyId;
    	$this->strKey = $this->Add_id($strKeyPrefix);
        parent::__construct($strTableName);
    }
    
    function ComposeKeyStr()
    {
    	return $this->ComposeIdStr($this->strKey);
    }

    function ComposeForeignKeyStr()
    {
		return $this->ComposeForeignStr($this->strKey);
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
    		return $this->DeleteData($this->BuildWhere_key());
    	}
    	return false;
    }
}

?>
