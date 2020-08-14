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

    function _onManualCrawl($strIp)
    {
    	$sql = $this->GetIpSql();
    	$sql->SetStatus(IP_STATUS_CRAWL, $strIp);
    }
    
    function AdminProcess()
    {
    	if ($strSymbol = UrlGetQueryValue('calibration'))
    	{
    		$this->_onManualCalibration($strSymbol);
    	}	
    	else if ($strIp = UrlGetQueryValue(TABLE_IP))
    	{
    		$this->_onManualCrawl($strIp);
    	}
    }
}

   	$acct = new _AdminOperationAccount();
	$acct->AdminRun();
?>
