<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibrtion($strSymbol)
{
	StockPrefetchData($strSymbol);
   	$ref = new EtfReference($strSymbol);
   	$ar = explode(' ', YahooGetWebData($ref));
   	$strNav = $ar[0];
   	$strDate = $ar[2];
	$ref->nv_ref->sql->Write($strDate, $strNav);
    if ($ref->GetPairSym())
    {
    	if ($fPairNav = $ref->pair_nv_ref->sql->GetClose($strDate))
    	{
    		$ref->sql->Write($strDate, strval($fPairNav / floatval($strNav)));
        }
    }
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
