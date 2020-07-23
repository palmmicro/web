<?php
require_once('account.php');
require_once('stock.php');

function _onManualCalibration($strSymbol)
{
	StockPrefetchData($strSymbol);
	EtfRefManualCalibration(new EtfReference($strSymbol));
}

function _onManualBlackList($strIp)
{
	$sql = new IpSql($strIp);
	$sql->SetStatus(IP_STATUS_BLOCKED);
}

function _AdminOperation()
{
    if ($strSymbol = UrlGetQueryValue('calibration'))
    {
        _onManualCalibration($strSymbol);
    }
    else if ($strIp = UrlGetQueryValue(TABLE_IP))
    {
        _onManualBlackList($strIp);
    }
}
	
   	$acct = new Account();
	$acct->AdminCommand('_AdminOperation');
?>
