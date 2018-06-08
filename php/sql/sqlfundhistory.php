<?php
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');

// ****************************** FundHistorySql class *******************************************************
class FundHistorySql extends DailyStockSql
{
	var $stock_sql;	// StockHistorySql
	
    // constructor 
    function FundHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_FUND_HISTORY);
        $this->stock_sql = new StockHistorySql($strStockId);
    }

    function Insert($strDate, $strClose, $strEstimated, $strTime)
    {
    	$strStockId = $this->GetId(); 
    	return $this->InsertData("(id, stock_id, date, close, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strClose', '$strEstimated', '$strTime')");
    }
    
    function Update($strId, $strNetValue, $strEstimated, $strTime)
    {
		return $this->UpdateById("close = '$strNetValue', estimated = '$strEstimated', time = '$strTime'", $strId);
	}
}

// ****************************** Fund History tables *******************************************************

// Date, Net Value, Estimated Value, Estimated Time
function SqlCreateFundHistoryTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`fundhistory` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `close` DOUBLE(13,6) NOT NULL ,'
         . ' `estimated` DOUBLE(10,4) NOT NULL ,'
         . ' `time` TIME NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `date`, `stock_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create fundhistory table failed');
}

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
//	$strQry = "INSERT INTO fundhistory(id, stock_id, date, close, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strNetValue', '$strEstimated', '$strTime')";
//	return SqlDieByQuery($strQry, 'Insert fundhistory table failed');
}

function SqlUpdateFundHistory($strId, $strNetValue, $strEstimated, $strTime)
{
	$sql = new FundHistorySql($strStockId);
	return $sql->Update($strId, $strNetValue, $strEstimated, $strTime);
}

?>
