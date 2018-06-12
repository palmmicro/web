<?php
require_once('sqltable.php');
require_once('sqlstocksymbol.php');

// ****************************** DailyStockSql class *******************************************************
class DailyStockSql extends StockTableSql
{
    // constructor 
    function DailyStockSql($strStockId, $strTableName) 
    {
        parent::StockTableSql($strStockId, $strTableName);
        $this->Create();
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

    function _getCloseString($strDate, $callback)
    {
    	if ($record = $this->$callback($strDate))
    	{
    		return $record['close'];
    	}
    	return false;
    }
    
    function _getClose($strDate, $callback)
    {
    	if ($str = $this->_getCloseString($strDate, $callback))
    	{
    		return floatval($str);
    	}
    	return false;
    }
    
    function Get($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_stock_date($strDate));
    }
    
    function GetCloseString($strDate)
    {
    	return $this->_getCloseString($strDate, 'Get');
    }

    function GetClose($strDate)
    {
    	return $this->_getClose($strDate, 'Get');
    }

    function GetFromDate($strDate, $iNum)
    {
    	return $this->GetData($this->BuildWhere_key()." AND date <= '$strDate'", _SqlOrderByDate(), _SqlBuildLimit(0, $iNum));
    }
    
    function GetPrev($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_key()." AND date < '$strDate'", _SqlOrderByDate());
    }

    function GetCloseStringPrev($strDate)
    {
    	return $this->_getCloseString($strDate, 'GetPrev');
    }

    function GetClosePrev($strDate)
    {
    	return $this->_getClose($strDate, 'GetPrev');
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

    function GetCloseStringNow()
    {
    	if ($record = $this->GetNow())
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetCloseNow()
    {
    	if ($str = $this->GetCloseStringNow())
    	{
    		return floatval($str);
    	}
    	return false;
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
    	return $this->GetData($this->BuildWhere_key(), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
    }

    function Insert($strDate, $strClose)
    {
    	$strStockId = $this->GetKeyId(); 
    	return $this->InsertData("(id, stock_id, date, close) VALUES('0', '$strStockId', '$strDate', '$strClose')");
    }

    function Update($strDate, $strClose)
    {
    	return $this->UpdateData("close = '$strClose'", $this->BuildWhere_stock_date($strDate), '1');
    }

    function Write($strDate, $strClose)
    {
    	if ($fSaved = $this->GetClose($strDate))
    	{
    		if (abs($fSaved - floatval($strClose)) > 0.000001)
    		{
    			DebugString($strDate.' '.$strClose);
    			$this->Update($strDate, $strClose);
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
}

// ****************************** StockEmaSql class *******************************************************
class StockEmaSql extends DailyStockSql
{
    // constructor 
    function StockEmaSql($strStockId, $iDays) 
    {
        parent::DailyStockSql($strStockId, 'stockema'.strval($iDays));
    }
}

// ****************************** ForexHistorySql class *******************************************************
class ForexHistorySql extends DailyStockSql
{
    // constructor 
    function ForexHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_FOREX_HISTORY);
    }
}

class UscnyHistorySql extends ForexHistorySql
{
    // constructor 
    function UscnyHistorySql() 
    {
        parent::ForexHistorySql(SqlGetStockId('USCNY'));
    }
}

class HkcnyHistorySql extends ForexHistorySql
{
    // constructor 
    function HkcnyHistorySql() 
    {
        parent::ForexHistorySql(SqlGetStockId('HKCNY'));
    }
}

// ****************************** Forex Support Functions *******************************************************
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

?>
