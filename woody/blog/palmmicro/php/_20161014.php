<?php
require_once('_palmmicro.php');

function EchoUpdateChinaFundLink()
{
	if (AcctIsAdmin())
	{
		EchoInternalLink('/php/test/updatechinafund.php', '更新A股基金数据');
	}
}

?>
