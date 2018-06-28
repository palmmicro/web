<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibrtion($strSymbol)
{
    StockPrefetchData($strSymbol);
   	$ref = new EtfReference($strSymbol);
	$str = TestYahooWebData($ref);
	DebugString($str);
//	$strStockId = $ref->GetStockId();
//    $sql = new EtfCalibrationSql($strStockId);
	DebugHere();
    if ($ref->GetPairSym())
    {
	DebugHere(10);
    	$ar = explode(' ', $str);
    	$strNav = $ar[0];
    	$strDate = $ar[2];
//    	$pair_nav_sql = new FundHistorySql($strPairId);
    	if ($fPairNav = $ref->pair_nv_ref->sql->GetClose($strDate))
    	{
	DebugHere(20);
    		DebugVal($fPairNav, 'Pair Nav');
//    		$nav_sql = new FundHistorySql($strStockId);
    		$ref->nv_ref->sql->Write($strDate, $strNav);
	DebugHere();
    		$ref->sql->Write($strDate, strval($fPairNav / floatval($strNav)));
        }
    }
	DebugHere();
}

    AcctNoAuth();
	if (AcctIsDebug())
	{
	    if ($strSymbol = UrlGetQueryValue('calibration'))
	    {
	        _onManualCalibrtion($strSymbol);
	    }
	}
	
	SwitchToSess();

?>
