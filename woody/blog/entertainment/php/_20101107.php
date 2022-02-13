<?php
require_once('_entertainment.php');

function EchoUpdateGbUtfLink()
{
   	if (DebugIsAdmin())
	{
		EchoInternalLink('/php/test/updategbutf.php', '更新UNICODE码表');
	}
}

?>
