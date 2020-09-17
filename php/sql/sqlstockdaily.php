<?php
require_once('sqlstocksymbol.php');
require_once('sqlkeytable.php');

// ****************************** DailyStockSql class *******************************************************
class DailyStockSql extends StockTableSql
{
    function DailyStockSql($strTableName, $strStockId) 
    {
        parent::StockTableSql($strTableName, $strStockId);
    }

    function ComposeDailyStr()
    {
    	return $this->ComposeKeyStr().','
         	  . ' `date` DATE NOT NULL ,';
    }
    
    function ComposeDailyIndexStr()
    {
    	return $this->ComposeForeignKeyStr().','
         	  . ' UNIQUE ( `date`, `stock_id` )';
    }
    
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
    
/*    function GetAll($iStart = 0, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key(), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
    }
*/
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
}

// ****************************** DailyStockStrSql class *******************************************************
class DailyStockStrSql extends DailyStockSql
{
    function DailyStockStrSql($strTableName, $strStockId) 
    {
        parent::DailyStockSql($strTableName, $strStockId);
    }

    function Create()
    {
        $str = $this->ComposeDailyStr()
         	  . ' `close` VARCHAR( 8192 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
        	  . $this->ComposeDailyIndexStr();
    	return $this->CreateIdTable($str);
    }
    
    function Insert($strDate, $strClose)
    {
        if ($this->GetRecord($strDate))			return false;
        
    	return $this->InsertArray($this->MakeFieldArray($strDate, $strClose));
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strDate))
    	{
    		if ($record['close'] != $strClose)
    		{
    			return $this->Update($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		return $this->Insert($strDate, $strClose);
    	}
    	return false;
    }
    
    function GetUniqueCloseArray()
    {
    	$ar = array();
    	if ($result = $this->GetAll()) 
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
                                            
// ****************************** DailyStockValSql class *******************************************************
class DailyStockValSql extends DailyStockSql
{
    function DailyStockValSql($strTableName, $strStockId) 
    {
        parent::DailyStockSql($strTableName, $strStockId);
    }

    function ComposeDailyValStr()
    {
    	return $this->ComposeDailyStr()
         	  . ' `close` DOUBLE(13,6) NOT NULL ,';
    }
    
    function Create()
    {
        $str = $this->ComposeDailyValStr()
        	  . $this->ComposeDailyIndexStr();
    	return $this->CreateIdTable($str);
    }

    function Insert($strDate, $strClose)
    {
        if ($this->GetRecord($strDate))			return false;
        
//        DebugString('StringYMD in DailyStockValSql->Insert');
        $ymd = new StringYMD($strDate);
        
        if ($ymd->IsWeekend())     			return false;   // sina fund may provide false weekend data
        
    	return $this->InsertArray($this->MakeFieldArray($strDate, $strClose));
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strDate))
    	{
    		if (abs(floatval($record['close']) - floatval($strClose)) > MIN_FLOAT_VAL)
    		{
    			return $this->Update($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		return $this->Insert($strDate, $strClose);
    	}
    	return false;
    }
    
    function DeleteZeroData()
    {
    	$this->DeleteCountData("close = '0.000000'");
    }
}

// ****************************** FundEstSql class *******************************************************
class FundEstSql extends DailyStockValSql
{
    function FundEstSql($strStockId = false) 
    {
        parent::DailyStockValSql(TABLE_FUND_EST, $strStockId);
    }

    function Create()
    {
        $str = $this->ComposeDailyValStr()
    		  . $this->ComposeTimeStr().','
        	  . $this->ComposeDailyIndexStr();
    	return $this->CreateIdTable($str);
    }
    
    function Insert($strDate, $strEstValue)
    {
   		$ar = $this->MakeFieldArray($strDate, $strEstValue);
   		$ar['time'] = DebugGetTime();
   		return $this->InsertArray($ar);
    }
    
    function Update($strId, $strEstValue)
    {
        $strTime = DebugGetTime();
		return $this->UpdateById(array('close' => $strEstValue, 'time' => $strTime), $strId);
	}
}

// ****************************** StockEmaSql class *******************************************************
class StockEmaSql extends DailyStockValSql
{
    function StockEmaSql($strStockId, $iDays) 
    {
        parent::DailyStockValSql('stockema'.strval($iDays), $strStockId);
    }
}

// ****************************** StockSplitSql class *******************************************************
class StockSplitSql extends DailyStockValSql
{
    function StockSplitSql($strStockId = false) 
    {
        parent::DailyStockValSql(TABLE_STOCK_SPLIT, $strStockId);
    }
}

// ****************************** SharesHistorySql class *******************************************************
class SharesHistorySql extends DailyKeySql
{
    function SharesHistorySql() 
    {
        parent::DailyKeySql('etfshareshistory');
    }
}

// ****************************** SharesDiffSql class *******************************************************
class SharesDiffSql extends DailyKeySql
{
    function SharesDiffSql() 
    {
        parent::DailyKeySql('etfsharesdiff');
    }
}

// ****************************** EtfCnhSql class *******************************************************
class EtfCnhSql extends DailyKeySql
{
    function EtfCnhSql() 
    {
        parent::DailyKeySql('etfcnh');
    }
}

// ****************************** NetValueHistorySql class *******************************************************
class NetValueHistorySql extends DailyStockValSql
{
    function NetValueHistorySql($strStockId) 
    {
        parent::DailyStockValSql(TABLE_NETVALUE_HISTORY, $strStockId);
    }
}

class UscnyHistorySql extends NetValueHistorySql
{
    function UscnyHistorySql() 
    {
        parent::NetValueHistorySql(SqlGetStockId('USCNY'));
    }
}

class HkcnyHistorySql extends NetValueHistorySql
{
    function HkcnyHistorySql() 
    {
        parent::NetValueHistorySql(SqlGetStockId('HKCNY'));
    }
}

// ****************************** Net Value Support Functions *******************************************************
function SqlGetHKCNY()
{
	$sql = new HkcnyHistorySql();
	return $sql->GetCloseNow();
}

function SqlGetUSCNY()
{
	$sql = new UscnyHistorySql();
	return $sql->GetCloseNow();
}

function SqlGetNetValueByDate($strStockId, $strDate)
{
	$sql = new NetValueHistorySql($strStockId);
	return $sql->GetClose($strDate);
}

// ****************************** AnnualIncomeStrSql class *******************************************************
class AnnualIncomeStrSql extends DailyStockStrSql
{
    function AnnualIncomeStrSql($strStockId = false) 
    {
        parent::DailyStockStrSql('annualincomestr', $strStockId);
    }
}

// ****************************** QuarterIncomeStrSql class *******************************************************
class QuarterIncomeStrSql extends DailyStockStrSql
{
    function QuarterIncomeStrSql($strStockId = false) 
    {
        parent::DailyStockStrSql('quarterincomestr', $strStockId);
    }
}

?>
