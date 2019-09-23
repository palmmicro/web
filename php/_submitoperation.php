<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibrtion($strSymbol)
{
	StockPrefetchData($strSymbol);
	EtfRefManualCalibrtion(new EtfReference($strSymbol));
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
