<?php
require_once('sqltable.php');
require_once('sqlstocksymbol.php');

// ****************************** DailyStockSql class *******************************************************
class DailyStockSql extends StockTableSql
{
    function DailyStockSql($strStockId, $strTableName) 
    {
        parent::StockTableSql($strStockId, $strTableName);
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
    
    function Get($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_stock_date($strDate));
    }
    
    function GetFromDate($strDate, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key()." AND date <= '$strDate'", _SqlOrderByDate(), _SqlBuildLimit(0, $iNum));
    }
    
    function GetPrev($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key()." AND date < '$strDate'", _SqlOrderByDate());
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
    	return $this->_getCloseString('Get', $strDate);
    }

    function GetClosePrev($strDate)
    {
    	return $this->_getCloseString('GetPrev', $strDate);
    }

    function GetNow($strDate = false)
    {
    	return $this->GetSingleData($this->BuildWhere_key(), _SqlOrderByDate());
    }
    
    function GetDateNow()
    {
    	if ($record = $this->GetNow())
    	{
    		return $record['date'];
    	}
    	return false;
    }

    function GetCloseNow()
    {
    	return $this->_getCloseString('GetNow');
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key(), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
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
}

// ****************************** DailyStockValSql class *******************************************************
class DailyStockStrSql extends DailyStockSql
{
    function DailyStockStrSql($strStockId, $strTableName) 
    {
        parent::DailyStockSql($strStockId, $strTableName);
    }

    function Create()
    {
        $str = $this->ComposeDailyStr()
         	  . ' `close` VARCHAR( 2048 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
        	  . $this->ComposeDailyIndexStr();
    	return $this->CreateIdTable($str);
    }
    
    function Insert($strDate, $strClose)
    {
        if ($this->Get($strDate))			return false;
        
    	return $this->InsertData($this->MakeFieldArray($strDate, $strClose));
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->Get($strDate))
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
}
                                               
// ****************************** DailyStockValSql class *******************************************************
class DailyStockValSql extends DailyStockSql
{
    function DailyStockValSql($strStockId, $strTableName) 
    {
        parent::DailyStockSql($strStockId, $strTableName);
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
        if ($this->Get($strDate))			return false;
        
        $ymd = new StringYMD($strDate);
        if ($ymd->IsWeekend())     			return false;   // sina fund may provide false weekend data
        
    	return $this->InsertData($this->MakeFieldArray($strDate, $strClose));
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->Get($strDate))
    	{
    		if (abs(floatval($record['close']) - floatval($strClose)) > 0.000001)
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
        parent::DailyStockValSql($strStockId, TABLE_FUND_EST);
    }

    function Create()
    {
        $str = $this->ComposeDailyValStr()
         	  . ' `time` TIME NOT NULL ,'
        	  . $this->ComposeDailyIndexStr();
    	return $this->CreateIdTable($str);
    }
    
    function Insert($strDate, $strEstValue)
    {
   		$ar = $this->MakeFieldArray($strDate, $strEstValue);
   		$ar['time'] = DebugGetTime();
   		return $this->InsertData($ar);
    }
    
    function Update($strId, $strEstValue)
    {
        $strTime = DebugGetTime();
		return $this->UpdateById(array('close' => $strEstValue, 'time' => $strTime), $strId);
	}
}

// ****************************** EtfCalibrationSql class *******************************************************
class EtfCalibrationSql extends DailyStockValSql
{
    function EtfCalibrationSql($strStockId)
    {
        parent::DailyStockValSql($strStockId, TABLE_ETF_CALIBRATION);
    }
}

// ****************************** StockEmaSql class *******************************************************
class StockEmaSql extends DailyStockValSql
{
    function StockEmaSql($strStockId, $iDays) 
    {
        parent::DailyStockValSql($strStockId, 'stockema'.strval($iDays));
    }
}

// ****************************** StockSplitSql class *******************************************************
class StockSplitSql extends DailyStockValSql
{
    function StockSplitSql($strStockId = false) 
    {
        parent::DailyStockValSql($strStockId, TABLE_STOCK_SPLIT);
    }
}

// ****************************** EtfSharesHistorySql class *******************************************************
class EtfSharesHistorySql extends DailyStockValSql
{
    function EtfSharesHistorySql($strStockId = false) 
    {
        parent::DailyStockValSql($strStockId, 'etfshareshistory');
    }
}

// ****************************** EtfSharesDiffSql class *******************************************************
class EtfSharesDiffSql extends DailyStockValSql
{
    function EtfSharesDiffSql($strStockId = false) 
    {
        parent::DailyStockValSql($strStockId, 'etfsharesdiff');
    }
}

// ****************************** EtfCnhSql class *******************************************************
class EtfCnhSql extends DailyStockValSql
{
    function EtfCnhSql($strStockId) 
    {
        parent::DailyStockValSql($strStockId, 'etfcnh');
    }
}

// ****************************** NetValueHistorySql class *******************************************************
class NetValueHistorySql extends DailyStockValSql
{
    function NetValueHistorySql($strStockId) 
    {
        parent::DailyStockValSql($strStockId, TABLE_NETVALUE_HISTORY);
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

// ****************************** AnnualIncomeSql class *******************************************************
class AnnualIncomeStrSql extends DailyStockStrSql
{
    function AnnualIncomeStrSql($strStockId = false) 
    {
        parent::DailyStockStrSql($strStockId, 'annualincomestr');
    }
}

?>
