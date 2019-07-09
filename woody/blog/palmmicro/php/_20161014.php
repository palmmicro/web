<?php
require_once('_palmmicro.php');
require_once('/woody/blog/php/_stockdemo.php');

function EchoUpdateUsStockLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updateusstock.php', '更新美股数据');
	}
}

function EchoUpdateChinaStockLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updatechinastock.php', '更新A股数据');
	}
}

function EchoUpdateChinaFundLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updatechinafund.php', '更新A股基金数据');
	}
}

?>
