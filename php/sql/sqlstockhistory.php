<?php
require_once('sqlstockdaily.php');

// ****************************** StockHistorySql class *******************************************************
class StockHistorySql extends DailyStockSql
{
    function StockHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, 'stockhistory');
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

    function Write($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$ar = array('date' => $strDate,
    				   'open' => $strOpen,
    				   'high' => $strHigh,
    				   'low' => $strLow,
    				   'close' => $strClose,
    				   'volume' => $strVolume,
    				   'adjclose' => $strAdjClose);
    	
    	if ($record = $this->Get($strDate))
    	{
    		unset($ar['date']);
    		if (abs(floatval($record['open']) - floatval($strOpen)) < 0.001)				unset($ar['open']);
    		if (abs(floatval($record['high']) - floatval($strHigh)) < 0.001)				unset($ar['high']);
    		if (abs(floatval($record['low']) - floatval($strLow)) < 0.001)					unset($ar['low']);
    		if (abs(floatval($record['close']) - floatval($strClose)) < 0.001)				unset($ar['close']);
    		if ($record['volume'] == $strVolume)												unset($ar['volume']);
    		if (abs(floatval($record['adjclose']) - floatval($strAdjClose)) < 0.000001)	unset($ar['adjclose']);
    		
    		if (count($ar) > 0)
    		{
//    			DebugKeyArray($ar);
    			return $this->UpdateById($ar, $record['id']);
    		}
    	}
    	else
    	{
    		return $this->InsertData(array_merge($this->GetFieldKeyId(), $ar));
    	}
    	return false;
    }
    
    function UpdateClose($strId, $strClose)
    {
		return $this->UpdateById(array('close' => $strClose, 'adjclose' => $strClose), $strId);
    }

    function UpdateAdjClose($strId, $strAdjClose)
    {
		return $this->UpdateById(array('adjclose' => $strAdjClose), $strId);
    }

    function DeleteByZeroVolume()
    {
    	return $this->DeleteData("volume = '0' AND ".$this->BuildWhere_key());
    }
}

?>
