<?php
require_once('_palmmicro.php');
require_once('/woody/blog/php/_stockdemo.php');

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

function EchoUpdateAdrLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updateadr.php', '更新H股ADR数据');
	}
}

function EchoUpdateAhLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updateah.php', '更新AH股数据');
	}
}

function EchoUpdateChinaFundLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updatechinafund.php', '更新A股基金数据');
	}
}

function EchoUpdateChinaBondLink($strType = 'gz')
{
   	if (DebugIsAdmin())
	{
		$ar = array('gz' => '国债', 'qz' => '企债', 'kzz' => '可转债');
		EchoInternalLink('/php/test/updatechinabond.php?type='.$strType, '更新A股'.$ar[$strType].'数据');
	}
}

function EchoUpdateDowJonesLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updatedowjones.php', '更新道琼斯成分股');
	}
}

?>
