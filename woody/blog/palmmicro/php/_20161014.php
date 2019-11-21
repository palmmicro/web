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

function EchoUpdateAbLink($strType = 'sh')
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		$ar = array('sh' => '上海', 'sz' => '深圳');
		EchoInternalLink('/php/test/updateab.php?type='.$strType, '更新'.$ar[$strType].'AB股数据');
	}
}

function EchoUpdateAdrLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updateadr.php', '更新H股ADR数据');
	}
}

function EchoUpdateAhLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updateah.php', '更新AH股数据');
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

function EchoUpdateDowJonesLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updatedowjones.php', '更新道琼斯成分股');
	}
}


?>
