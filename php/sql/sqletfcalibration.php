<?php
require_once('sqlstockpair.php');
//require_once('sqlstockdaily.php');

// ****************************** EtfCalibrationSql class *******************************************************
class EtfCalibrationSql extends DailyStockSql
{
	var $pair_sql;		// PairStockSql
	
    function EtfCalibrationSql($strStockId)
    {
        parent::DailyStockSql($strStockId, TABLE_ETF_CALIBRATION);
        $this->pair_sql = new PairStockSql($strStockId, TABLE_ETF_PAIR);
    }
}

?>
