<?php
require_once('account.php');
require_once('stock.php');

class _AdminOperationAccount extends Account
{
    public function AdminProcess()
    {
    	if ($strArbitrage = UrlGetQueryValue('fundarbitrage'))
    	{
    		$sql = new FundArbitrageSql();
    		$sql->WriteInt(UrlGetQueryValue('stockid'), $strArbitrage);
    	}
    	else if ($strPosition = UrlGetQueryValue('fundposition'))
    	{
    		$sql = new FundPositionSql();
    		$sql->WriteVal(UrlGetQueryValue('stockid'), $strPosition);
    	}
    	else if ($strIp = UrlGetQueryValue('ip'))
    	{
    		$this->SetCrawler($strIp);
    	}
    	else if ($strIp = UrlGetQueryValue('maliciousip'))
    	{
    		$this->SetMalicious($strIp);
    	}
    }
}

   	$acct = new _AdminOperationAccount();
	$acct->AdminRun();
?>
