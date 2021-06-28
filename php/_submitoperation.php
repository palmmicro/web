<?php
require_once('account.php');
require_once('stock.php');

class _AdminOperationAccount extends Account
{
	function _onManualCalibration($strSymbol)
	{
		StockPrefetchData($strSymbol);
		EtfRefManualCalibration(new EtfReference($strSymbol));
	}

    function AdminProcess()
    {
    	if ($strSymbol = UrlGetQueryValue(TABLE_CALIBRATION))
    	{
    		$this->_onManualCalibration($strSymbol);
    	}	
    	else if ($strIp = UrlGetQueryValue(TABLE_IP))
    	{
    		$this->SetCrawler($strIp);
    	}
    }
}

   	$acct = new _AdminOperationAccount();
	$acct->AdminRun();
?>
