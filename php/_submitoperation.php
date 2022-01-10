<?php
require_once('account.php');
require_once('stock.php');

class _AdminOperationAccount extends Account
{
	function _onManualCalibration($strSymbol)
	{
		StockPrefetchExtendedData($strSymbol);
		$ref = new EtfReference($strSymbol);
		$ref->ManualCalibration();
	}

    function AdminProcess()
    {
    	if ($strSymbol = UrlGetQueryValue(TABLE_CALIBRATION_HISTORY))
    	{
    		$this->_onManualCalibration($strSymbol);
    	}	
    	else if ($strIp = UrlGetQueryValue(TABLE_IP))
    	{
    		$this->SetCrawler($strIp);
    	}
    	else if ($strIp = UrlGetQueryValue('malicious'.TABLE_IP))
    	{
    		$this->SetMalicious($strIp);
    	}
    }
}

   	$acct = new _AdminOperationAccount();
	$acct->AdminRun();
?>
