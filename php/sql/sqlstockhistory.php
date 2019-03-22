<?php
require_once('sqlstockdaily.php');

// ****************************** StockHistorySql class *******************************************************
class StockHistorySql extends DailyStockSql
{
    function StockHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_STOCK_HISTORY);
        $this->Create();
    }

    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `open` DOUBLE(10,3) NOT NULL ,'
         	  . ' `high` DOUBLE(10,3) NOT NULL ,'
         	  . ' `low` DOUBLE(10,3) NOT NULL ,'
         	  . ' `close` DOUBLE(10,3) NOT NULL ,'
         	  . ' `volume` BIGINT UNSIGNED NOT NULL ,'
         	  . ' `adjclose` DOUBLE(13,6) NOT NULL ,'
         	  . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `date`, `stock_id` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$strStockId = $this->GetKeyId(); 
    	return $this->InsertData("(id, stock_id, date, open, high, low, close, volume, adjclose) VALUES('0', '$strStockId', '$strDate', '$strOpen', '$strHigh', '$strLow', '$strClose', '$strVolume', '$strAdjClose')");
    }
    
    function Update($strId, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
		return $this->UpdateById("open = '$strOpen', high = '$strHigh', low = '$strLow', close = '$strClose', volume = '$strVolume', adjclose = '$strAdjClose'", $strId);
    }

    function Merge($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	if ($history = $this->Get($strDate))
    	{
    		$this->Update($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    	}
    	else
    	{
    		$this->Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    	}
    }
    
    function UpdateClose($strId, $strClose)
    {
		return $this->UpdateById("close = '$strClose', adjclose = '$strClose'", $strId);
    }

    function UpdateAdjClose($strId, $strAdjClose)
    {
		return $this->UpdateById("adjclose = '$strAdjClose'", $strId);
    }

    function DeleteByZeroVolume()
    {
    	return $this->DeleteData("volume = '0' AND ".$this->BuildWhere_key());
    }
}

?>
