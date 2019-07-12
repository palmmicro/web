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

function EchoUpdateChinaBondLink($strType = 'gz')
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		$ar = array('gz' => '国债', 'qz' => '企债', 'kzz' => '可转债');
		EchoInternalLink('/php/test/updatechinabond.php?type='.$strType, '更新A股'.$ar[$strType].'数据');
	}
}

?>
