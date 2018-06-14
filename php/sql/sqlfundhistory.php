<?php
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');

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
    
    function Insert($strDate, $strClose, $strEstimated, $strTime)
    {
    	if ($strStockId = $this->GetKeyId())
    	{
    		return $this->InsertData("(id, stock_id, date, close, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strClose', '$strEstimated', '$strTime')");
    	}
    	return false;
    }
    
    function Update($strId, $strNetValue, $strEstimated, $strTime)
    {
		return $this->UpdateById("close = '$strNetValue', estimated = '$strEstimated', time = '$strTime'", $strId);
	}
}

// ****************************** Fund History tables *******************************************************

function SqlGetFundHistoryNow($strStockId)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->GetNow();
}

function SqlGetFundHistoryByDate($strStockId, $strDate)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->Get($strDate);
}

function SqlGetFundNetValueByDate($strStockId, $strDate)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->GetClose($strDate);
}

function SqlInsertFundHistory($strStockId, $strDate, $strNetValue, $strEstimated, $strTime)
{
	DebugString('Insert fund history '.SqlGetStockSymbol($strStockId));
	$sql = new FundHistorySql($strStockId);
	return $sql->Insert($strDate, $strNetValue, $strEstimated, $strTime);
}

function SqlUpdateFundHistory($strId, $strNetValue, $strEstimated, $strTime)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->Update($strId, $strNetValue, $strEstimated, $strTime);
}

?>
