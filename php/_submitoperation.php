<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibration($strSymbol)
{
	StockPrefetchData($strSymbol);
	EtfRefManualCalibration(new EtfReference($strSymbol));
}

    AcctNoAuth();
	if (AcctIsAdmin())
	{
	    if ($strSymbol = UrlGetQueryValue('calibration'))
	    {
	        _onManualCalibration($strSymbol);
	    }
	}
	
	SwitchToSess();

?>
