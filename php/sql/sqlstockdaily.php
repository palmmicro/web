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
    
    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `date`, `stock_id` )';
    	return $this->CreateTable($str);
    }

    function _getPrivateFieldArray($strDate, $strClose)
    {
    	return array('date' => $strDate, 'close' => $strClose);
    }
    
    function GetFieldArray($strDate, $strClose)
    {
    	return array_merge($this->GetFieldKeyId(), $this->_getPrivateFieldArray($strDate, $strClose));
    }
    
    function _getCloseString($strDate, $callback)
    {
    	if ($record = $this->$callback($strDate))
    	{
    		return $record['close'];
    	}
    	return false;
    }
    
    function Get($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_stock_date($strDate));
    }
    
    function GetClose($strDate)
    {
    	return $this->_getCloseString($strDate, 'Get');
    }

    function GetFromDate($strDate, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key()." AND date <= '$strDate'", _SqlOrderByDate(), _SqlBuildLimit(0, $iNum));
    }
    
    function GetPrev($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key()." AND date < '$strDate'", _SqlOrderByDate());
    }

    function GetClosePrev($strDate)
    {
    	return $this->_getCloseString($strDate, 'GetPrev');
    }

    function GetNow()
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
    	if ($record = $this->GetNow())
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key(), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
    }

    function Insert($strDate, $strClose)
    {
        if ($this->Get($strDate))			return false;
        
        $ymd = new StringYMD($strDate);
        if ($ymd->IsWeekend())     			return false;   // sina fund may provide false weekend data
        
    	return $this->InsertData($this->GetFieldArray($strDate, $strClose));
    }

    function Update($strId, $strClose)
    {
		return $this->UpdateById(array('close' => $strClose), $strId);
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->Get($strDate))
    	{
    		if (abs(floatval($record['close']) - floatval($strClose)) > 0.000001)
    		{
    			$this->Update($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		$this->Insert($strDate, $strClose);
    	}
    }
    
    function DeleteByDate($strDate)
    {
    	return $this->DeleteData($this->BuildWhere_stock_date($strDate), '1');
    }
    
    function DeleteZeroData()
    {
    	$this->DeleteCountData("close = '0.000000'");
    }
}

// ****************************** FundEstSql class *******************************************************
class FundEstSql extends DailyStockSql
{
    function FundEstSql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_FUND_EST);
    }

    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . ' `time` TIME NOT NULL ,'
         	  . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `date`, `stock_id` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strDate, $strEstValue)
    {
   		$ar = $this->GetFieldArray($strDate, $strEstValue);
   		list($strDummy, $strTime) = explodeDebugDateTime();
   		$ar['time'] = $strTime;
   		return $this->InsertData($ar);
    }
    
    function Update($strId, $strEstValue)
    {
        list($strDummy, $strTime) = explodeDebugDateTime();
		return $this->UpdateById(array('close' => $strEstValue, 'time' => $strTime), $strId);
	}
}

// ****************************** EtfCalibrationSql class *******************************************************
class EtfCalibrationSql extends DailyStockSql
{
    function EtfCalibrationSql($strStockId)
    {
        parent::DailyStockSql($strStockId, TABLE_ETF_CALIBRATION);
    }
}

// ****************************** StockEmaSql class *******************************************************
class StockEmaSql extends DailyStockSql
{
    function StockEmaSql($strStockId, $iDays) 
    {
        parent::DailyStockSql($strStockId, 'stockema'.strval($iDays));
    }
}

// ****************************** StockSplitSql class *******************************************************
class StockSplitSql extends DailyStockSql
{
    function StockSplitSql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_STOCK_SPLIT);
    }
}

// ****************************** NetValueHistorySql class *******************************************************
class NetValueHistorySql extends DailyStockSql
{
    function NetValueHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_NETVALUE_HISTORY);
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
	return floatval($sql->GetCloseNow());
}

function SqlGetUSCNY()
{
	$sql = new UscnyHistorySql();
	return floatval($sql->GetCloseNow());
}

function SqlGetNetValueByDate($strStockId, $strDate)
{
	$sql = new NetValueHistorySql($strStockId);
	return $sql->GetClose($strDate);
}

?>
