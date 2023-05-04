<?php
require_once('_entertainment.php');

function EchoUpdateGbUtfLink()
{
   	if (DebugIsAdmin())
	{
		echo GetInternalLink('/php/test/updategbutf.php', '更新UNICODE码表');
	}
}

?>
