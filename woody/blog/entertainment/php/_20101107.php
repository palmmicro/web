<?php
require_once('_entertainment.php');

function EchoUpdateGbUtfLink()
{
    global $acct;
   	if ($acct->IsAdmin())
	{
		EchoInternalLink('/php/test/updategbutf.php', '更新UNICODE码表');
	}
}

?>
