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
class FundEstSql extends DailyTimeSql
{
    function FundEstSql() 
    {
        parent::DailyTimeSql(TABLE_FUND_EST);
    }
}

// ****************************** StockSplitSql class *******************************************************
class StockSplitSql extends DailyCloseSql
{
    function StockSplitSql() 
    {
        parent::DailyCloseSql(TABLE_STOCK_SPLIT);
    }
}

// ****************************** SharesHistorySql class *******************************************************
class SharesHistorySql extends DailyCloseSql
{
    function SharesHistorySql() 
    {
        parent::DailyCloseSql('etfshareshistory');
    }
}

// ****************************** SharesDiffSql class *******************************************************
class SharesDiffSql extends DailyCloseSql
{
    function SharesDiffSql() 
    {
        parent::DailyCloseSql('etfsharesdiff');
    }
}

// ****************************** EtfCnhSql class *******************************************************
class EtfCnhSql extends DailyCloseSql
{
    function EtfCnhSql() 
    {
        parent::DailyCloseSql('etfcnh');
    }
}

// ****************************** NetValueSql class *******************************************************
class NetValueSql extends DailyStockValSql
{
    function NetValueSql($strStockId) 
    {
        parent::DailyStockValSql(TABLE_NETVALUE_HISTORY, $strStockId);
    }
}

// ****************************** AnnualIncomeSql class *******************************************************
class AnnualIncomeSql extends DailyStringSql
{
    function AnnualIncomeSql() 
    {
        parent::DailyStringSql('annualincomestr');
    }
}

// ****************************** QuarterIncomeSql class *******************************************************
class QuarterIncomeSql extends DailyStringSql
{
    function QuarterIncomeSql() 
    {
        parent::DailyStringSql('quarterincomestr');
    }
}

?>
