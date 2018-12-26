<?php
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');

define('FUND_EMPTY_VALUE', '0.000000');

function IsEmptyFundValue($strVal)
{
	if ($strVal == FUND_EMPTY_VALUE)
	{
		return true;
	}
	return false;
}

// ****************************** FundHistorySql class *******************************************************
class FundHistorySql extends DailyStockSql
{
    function FundHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_FUND_HISTORY);
        $this->Create();
    }

    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . ' `estimated` DOUBLE(13,6) NOT NULL ,'
         	  . ' `time` TIME NOT NULL ,'
         	  . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `date`, `stock_id` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strDate, $strClose, $strEstValue = FUND_EMPTY_VALUE, $strTime = '00:00:00')
    {
    	if ($strStockId = $this->GetKeyId())
    	{
    		return $this->InsertData("(id, stock_id, date, close, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strClose', '$strEstValue', '$strTime')");
    	}
    	return false;
    }
    
    function Update($strId, $strNetValue, $strEstValue, $strTime)
    {
		return $this->UpdateById("close = '$strNetValue', estimated = '$strEstValue', time = '$strTime'", $strId);
	}
	
	function Write($strDate, $strNetValue)
	{
        if ($history = $this->Get($strDate))
        {
            $this->Update($history['id'], $strNetValue, $history['estimated'], $history['time']);
        }
        else
        {
        	$this->Insert($strDate, $strNetValue);
        }
	}
	
	function GetEstimated($strDate)
	{
        if ($history = $this->Get($strDate))
        {
			return $history['estimated'];
        }
        return false;
	}
	
	function IsEmptyNetValue($history)
	{
        return IsEmptyFundValue($history['close']);
	}
	
	function UpdateEstValue($strDate, $fEstValue)
	{
        list($strDummy, $strTime) = explodeDebugDateTime();
        $strEstValue = strval($fEstValue);
        // DebugString(SqlGetStockSymbol($this->GetKeyId()).' '.$strTime.' '.$strEstValue);
        if ($history = $this->Get($strDate))
        {
            if ($this->IsEmptyNetValue($history))
            {   // Only update when net value is NOT ready
            	// DebugString($strDate.' '.$strEstValue);
            	if (abs($fEstValue - floatval($history['estimated'])) > 0.00005)
            	{
            		$this->Update($history['id'], FUND_EMPTY_VALUE, $strEstValue, $strTime);
            	}
            }
        }
        else
        {
            $this->Insert($strDate, FUND_EMPTY_VALUE, $strEstValue, $strTime);
        }
	}
}


?>
