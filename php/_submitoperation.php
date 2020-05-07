<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibration($strSymbol)
{
	StockPrefetchData($strSymbol);
	EtfRefManualCalibration(new EtfReference($strSymbol));
}

function _AdminOperation()
{
    if ($strSymbol = UrlGetQueryValue('calibration'))
    {
        _onManualCalibration($strSymbol);
    }
}
	
   	$acct = new Account();
	$acct->AdminCommand('_AdminOperation');
?>
