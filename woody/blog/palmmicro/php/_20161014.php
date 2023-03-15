<?php
require_once('_palmmicro.php');
require_once('../php/_stockdemo.php');

function EchoUpdateUsStockLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updateusstock.php', '更新美股数据');
	}
}

function EchoUpdateChinaStockLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updatechinastock.php', '更新A股数据');
	}
}

function EchoUpdateAbLink($strType = 'sh')
{
   	if (DebugIsAdmin())
	{
		$ar = array('sh' => '上海', 'sz' => '深圳');
		EchoInternalLink('/php/test/updateab.php?type='.$strType, '更新'.$ar[$strType].'AB股数据');
	}
}

function EchoUpdateChinaFundLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updatechinafund.php', '更新A股基金数据');
	}
}

?>
