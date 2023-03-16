<?php
require_once('_palmmicro.php');
require_once('../php/_stockdemo.php');

function EchoUpdateChinaFundLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updatechinafund.php', '更新A股基金数据');
	}
}

?>
