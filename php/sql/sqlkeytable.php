<?php
require_once('sqlkeyname.php');

class KeyTableSql extends TableSql
{
	var $strKey;
	var $strKeyId;
	
    function KeyTableSql($strTableName, $strKeyId, $strKeyPrefix) 
    {
    	$this->strKeyId = $strKeyId;
    	$this->strKey = $this->Add_id($strKeyPrefix);
        parent::TableSql($strTableName);
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
    		return $this->DeleteRecord($this->BuildWhere_key());
    	}
    	return false;
    }
}

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
    
    public function BuildOrderBy()
    {
    	return false;
    }
    
    function BuildWhere_key($strKeyId)
    {
    	return _SqlBuildWhere($this->strKey, $strKeyId);
    }
    
    function Count($strKeyId)
    {
    	return $this->CountData($this->BuildWhere_key($strKeyId));
    }

    public function GetAll($strKeyId = false, $iStart = 0, $iNum = 0)
    {
   		return $this->GetData($this->BuildWhere_key($strKeyId), $this->BuildOrderBy(), _SqlBuildLimit($iStart, $iNum));
    }

    function DeleteAll($strKeyId)
    {
    	if ($strKeyId !== false)
    	{
    		return $this->DeleteRecord($this->BuildWhere_key($strKeyId));
    	}
    	return false;
    }
}

class DailyKeySql extends KeySql
{
    function DailyKeySql($strTableName, $strKeyPrefix = TABLE_STOCK) 
    {
        parent::KeySql($strTableName, $strKeyPrefix);
    }

    function ComposeUniqueDateStr()
    {
		return ' UNIQUE ( `date`, `'.$this->GetKeyIndex().'` ) ';
    }
    
    public function Create()
    {
    	$str = $this->ComposeKeyStr().','
    		  . $this->ComposeDateStr().','
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . $this->ComposeForeignKeyStr().','
         	  . $this->ComposeUniqueDateStr();
    	return $this->CreateIdTable($str);
    }
/*
    function BuildWhere_stock_date($strDate)
    {
		return $this->BuildWhere_key_extra('date', $strDate);
    }
    
    function GetFromDate($strDate, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key()." AND date <= '$strDate'", _SqlOrderByDate(), _SqlBuildLimit(0, $iNum));
    }
    
    function GetRecordPrev($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key()." AND date < '$strDate'", _SqlOrderByDate());
    }

    function GetRecord($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_stock_date($strDate));
    }
    
    function _getCloseString($callback, $strDate = false)
    {
    	if ($record = $this->$callback($strDate))
    	{
    		return rtrim0($record['close']);
    	}
    	return false;
    }
    
    function GetClose($strDate)
    {
    	return $this->_getCloseString('GetRecord', $strDate);
    }

    function GetClosePrev($strDate)
    {
    	return $this->_getCloseString('GetRecordPrev', $strDate);
    }

    function GetDateNow()
    {
    	if ($record = $this->GetRecordNow())
    	{
    		return $record['date'];
    	}
    	return false;
    }

    function GetCloseNow()
    {
    	return $this->_getCloseString('GetRecordNow');
    }

    function BuildOrderBy()
    {
    	return _SqlOrderByDate();
    }
    
    function _makePrivateFieldArray($strDate, $strClose)
    {
    	return array('date' => $strDate, 'close' => $strClose);
    }
    
    function MakeFieldArray($strDate, $strClose)
    {
    	return array_merge($this->MakeFieldKeyId(), $this->_makePrivateFieldArray($strDate, $strClose));
    }
    
    function Update($strId, $strClose)
    {
		return $this->UpdateById(array('close' => $strClose), $strId);
    }

    function WriteArray($ar)
    {
		foreach ($ar as $strDate => $strClose)
		{
			$this->Write($strDate, $strClose);
		}
    }
    
    function IsInvalidDate($record)
    {
		$ymd = new OldestYMD();
    	return $ymd->IsInvalid($record['date']);
    }
    
    function DeleteInvalidDate()
    {
    	return $this->DeleteInvalid('IsInvalidDate');
    }
    
    function DeleteByDate($strDate)
    {
    	if ($strWhere = $this->BuildWhere_stock_date($strDate))
    	{
    		return $this->DeleteRecord($strWhere);
    	}
    	return false;
    }
*/
}


?>
