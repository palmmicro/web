<?php
require_once('sqltable.php');
require_once('sqlstocksymbol.php');

// ****************************** DailyStockSql class *******************************************************
class DailyStockSql extends StockTableSql
{
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
    
    function Get($strDate)
    {
    	return $this->GetSingleData($this->BuildWhere_stock_date($strDate));
    }
    
    function GetClose($strDate)
    {
    	return $this->_getCloseString($strDate, 'Get');
    }

    function GetFromDate($strDate, $iNum)
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
        
    	$strStockId = $this->GetKeyId(); 
    	return $this->InsertData("(id, stock_id, date, close) VALUES('0', '$strStockId', '$strDate', '$strClose')");
    }

    function Update($strId, $strClose)
    {
		return $this->UpdateById("close = '$strClose'", $strId);
//    	return $this->UpdateData("close = '$strClose'", $this->BuildWhere_stock_date($strDate), '1');
    }

    function Write($strDate, $strClose)
    {
    	if ($record = $this->Get($strDate))
    	{
//    		DebugString('DailyStockSql Write '.$record['close'].' '.$strClose);
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
        $this->Create();
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
//    	DebugString('FundEstSql Insert: '.$strDate.' '.$strEstValue);
    	if ($strStockId = $this->GetKeyId())
    	{
    		list($strDummy, $strTime) = explodeDebugDateTime();
    		return $this->InsertData("(id, stock_id, date, close, time) VALUES('0', '$strStockId', '$strDate', '$strEstValue', '$strTime')");
    	}
    	return false;
    }
    
    function Update($strId, $strEstValue)
    {
//    	DebugString('FundEstSql Update: '.$strEstValue);
        list($strDummy, $strTime) = explodeDebugDateTime();
		return $this->UpdateById("close = '$strEstValue', time = '$strTime'", $strId);
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

// ****************************** NavHistorySql class *******************************************************
class NavHistorySql extends DailyStockSql
{
    function NavHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_NAV_HISTORY);
    }
}

class UscnyHistorySql extends NavHistorySql
{
    function UscnyHistorySql() 
    {
        parent::NavHistorySql(SqlGetStockId('USCNY'));
    }
}

class HkcnyHistorySql extends NavHistorySql
{
    function HkcnyHistorySql() 
    {
        parent::NavHistorySql(SqlGetStockId('HKCNY'));
    }
}

// ****************************** Nav Support Functions *******************************************************
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
	$sql = new NavHistorySql($strStockId);
	return $sql->GetClose($strDate);
}

?>
