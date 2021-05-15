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
    
    function ComposeCloseStr()
    {
		return ' `close` DOUBLE(13,6) NOT NULL ';
    }
    
    function CreateDailyKeyTable($str)
    {
    	$str = $this->ComposeKeyStr().','
    		  . $this->ComposeDateStr().','
         	  . $str.','
         	  . $this->ComposeForeignKeyStr().','
         	  . $this->ComposeUniqueDateStr();
    	return $this->CreateIdTable($str);
    }
    
    public function Create()
    {
        return $this->CreateDailyKeyTable($this->ComposeCloseStr());
    }

    public function BuildOrderBy()
    {
    	return _SqlOrderByDate();
    }
    
    function GetFromDate($strKeyId, $strDate, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key($strKeyId)." AND date <= '$strDate'", $this->BuildOrderBy(), _SqlBuildLimit(0, $iNum));
    }
    
    function GetRecordPrev($strKeyId, $strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key($strKeyId)." AND date < '$strDate'", $this->BuildOrderBy());
    }

    function BuildWhere_key_date($strKeyId, $strDate)
    {
    	$ar = $this->MakeFieldKeyId($strKeyId);
    	$ar['date'] = $strDate;
		return _SqlBuildWhereAndArray($ar);
    }
    
    function GetRecord($strKeyId, $strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key_date($strKeyId, $strDate));
    }

    function _getCloseString($callback, $strKeyId, $strDate = false)
    {
    	if ($record = $this->$callback($strKeyId, $strDate))
    	{
    		return rtrim0($record['close']);
    	}
    	return false;
    }
    
    function GetClose($strKeyId, $strDate)
    {
    	return $this->_getCloseString('GetRecord', $strKeyId, $strDate);
    }

    function GetClosePrev($strKeyId, $strDate)
    {
    	return $this->_getCloseString('GetRecordPrev', $strKeyId, $strDate);
    }

    function GetDateNow($strKeyId = false)
    {
    	if ($record = $this->GetRecordNow($strKeyId))
    	{
    		return $record['date'];
    	}
    	return false;
    }

    function GetCloseNow($strKeyId = false)
    {
    	return $this->_getCloseString('GetRecordNow', $strKeyId);
    }

	function MakeFieldArray($strKeyId, $strDate, $strClose)
    {
    	return array_merge($this->MakeFieldKeyId($strKeyId), array('date' => $strDate, 'close' => $strClose));
    }
    
    function InsertDaily($strKeyId, $strDate, $strClose)
    {
        if ($this->GetRecord($strKeyId, $strDate))			return false;
    	return $this->InsertArray($this->MakeFieldArray($strKeyId, $strDate, $strClose));
    }

    function UpdateDaily($strId, $strClose)
    {
		return $this->UpdateById(array('close' => $strClose), $strId);
    }

    public function WriteDaily($strKeyId, $strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strKeyId, $strDate))
    	{
    		if (abs(floatval($record['close']) - floatval($strClose)) > MIN_FLOAT_VAL)
    		{
    			return $this->UpdateDaily($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		$ymd = new StringYMD($strDate);
    		if ($ymd->IsWeekend())     			return false;   // sina fund may provide false weekend data
    		
    		return $this->InsertDaily($strKeyId, $strDate, $strClose);
    	}
    	return false;
    }
    
    function WriteDailyArray($strKeyId, $ar)
    {
		foreach ($ar as $strDate => $strClose)
		{
			$this->WriteDaily($strKeyId, $strDate, $strClose);
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
    
    function DeleteByDate($strKeyId, $strDate)
    {
    	if ($strWhere = $this->BuildWhere_key_date($strKeyId, $strDate))
    	{
    		return $this->DeleteRecord($strWhere);
    	}
    	return false;
    }

    function DeleteClose($str = '0.000000')
    {
    	$this->DeleteCountData("close = '$str'");
    }

    function ModifyDaily($strKeyId, $strDate, $strClose)
    {
    	if (empty($strClose))
    	{
    		$this->DeleteByDate($strKeyId, $strDate);
    	}
    	else
    	{
    		$this->WriteDaily($strKeyId, $strDate, $strClose);
    	}
    }
}

class DailyStringSql extends DailyKeySql
{
    function DailyStringSql($strTableName, $strKeyPrefix = TABLE_STOCK) 
    {
        parent::DailyKeySql($strTableName, $strKeyPrefix);
    }

    public function Create()
    {
        return $this->CreateDailyKeyTable(' `close` VARCHAR( 8192 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ');
    }

    public function WriteDaily($strKeyId, $strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strKeyId, $strDate))
    	{
    		if ($record['close'] != $strClose)
    		{
    			return $this->UpdateDaily($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		return $this->InsertDaily($strKeyId, $strDate, $strClose);
    	}
    	return false;
    }

    function GetUniqueCloseArray($strKeyId)
    {
    	$ar = array();
    	if ($result = $this->GetAll($strKeyId)) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$arClose = explode(',', $record['close']);
    			$ar = array_merge($ar, array_unique($arClose));
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }
}

?>
