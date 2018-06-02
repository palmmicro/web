<?php
require_once('sqlstockpair.php');
//require_once('sqlstockdaily.php');
require_once('sqlfundhistory.php');

// ****************************** EtfCalibrationSql class *******************************************************
class EtfCalibrationSql extends DailyStockSql
{
	var $pair_sql;		// PairStockSql
	var $pair_fund_sql;	// FundHistorySql
	var $fund_sql;		// FundHistorySql
	
    function EtfCalibrationSql($strStockId)
    {
        parent::DailyStockSql($strStockId, TABLE_ETF_CALIBRATION);
        
        $this->pair_sql = new PairStockSql($strStockId, TABLE_ETF_PAIR);
        $strPairId = $this->pair_sql->GetPairId();
        
       	$this->pair_fund_sql = new FundHistorySql($strPairId);
       	$this->fund_sql = new FundHistorySql($strStockId);
    }
}

?>
