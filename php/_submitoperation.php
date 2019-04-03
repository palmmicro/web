<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibrtion($strSymbol)
{
	StockPrefetchData($strSymbol);
   	$ref = new EtfReference($strSymbol);
   	$ar = explode(' ', YahooGetWebData($ref));
   	$strNetValue = $ar[0];
   	$strDate = $ar[2];
	$ref->nv_ref->sql->Write($strDate, $strNetValue);
    if ($ref->GetPairSym())
    {
    	if ($strPairNetValue = $ref->pair_nv_ref->sql->GetClose($strDate))
    	{
    		$ref->sql->Write($strDate, strval(floatval($strPairNetValue) / floatval($strNetValue)));
        }
    }
}

    AcctNoAuth();
	if (AcctIsAdmin())
	{
	    if ($strSymbol = UrlGetQueryValue('calibration'))
	    {
	        _onManualCalibrtion($strSymbol);
	    }
	}
	
	SwitchToSess();

?>
