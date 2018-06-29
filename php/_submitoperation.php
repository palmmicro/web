<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibrtion($strSymbol)
{
DebugHere();
	StockPrefetchData($strSymbol);
   	$ref = new EtfReference($strSymbol);
   	$ar = explode(' ', YahooGetWebData($ref));
   	$strNav = $ar[0];
   	$strDate = $ar[2];
	$ref->nv_ref->sql->Write($strDate, $strNav);
DebugHere();
    if ($ref->GetPairSym())
    {
DebugHere(10);
    	if ($fPairNav = $ref->pair_nv_ref->sql->GetClose($strDate))
    	{
DebugHere(20);
    		$ref->sql->Write($strDate, strval($fPairNav / floatval($strNav)));
        }
DebugHere();
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
