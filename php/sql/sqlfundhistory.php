<?php
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');

define('FUND_EMPTY_VALUE', '0.0000');

// ****************************** FundHistorySql class *******************************************************
class FundHistorySql extends DailyStockSql
{
	var $stock_sql;	// StockHistorySql
	
    // constructor 
    function FundHistorySql($strStockId = false) 
    {
        parent::DailyStockSql($strStockId, TABLE_FUND_HISTORY);
        $this->Create();
        
        $this->stock_sql = new StockHistorySql($strStockId);
    }

    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . ' `estimated` DOUBLE(10,4) NOT NULL ,'
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
	
	function UpdateNetValue($strDate, $strNetValue)
	{
        $ymd = new StringYMD($strDate);
        if ($ymd->IsWeekend())     return false;   // sina fund may provide false weekend data
        
        if ($history = $this->Get($strDate))
        {
            if ($history['close'] == FUND_EMPTY_VALUE)
            {
                $strEstValue = $history['estimated'];
                $this->Update($history['id'], $strNetValue, $strEstValue, $history['time']);
                return $strEstValue;
            }
            else
            {	// We already have it
                return false;
            }
        }
        $this->Insert($strDate, $strNetValue);
        return $strNetValue;
	}
	
	function UpdateEstValue($strDate, $fEstValue)
	{
        list($strDummy, $strTime) = explodeDebugDateTime();
        $strEstValue = strval($fEstValue);
        if ($history = $this->Get($strDate))
        {
            if ($history['close'] == FUND_EMPTY_VALUE)
            {   // Only update when net value is not ready
            	// DebugString($strDate.' '.$strEstValue);
            	if (abs($fEstValue - floatval($history['estimated'])) < 0.00005)
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

// ****************************** Fund History tables *******************************************************

function SqlGetFundNetValueByDate($strStockId, $strDate)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->GetClose($strDate);
}

?>
