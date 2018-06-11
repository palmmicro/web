<?php
require_once('weixin.php');
require_once('sql.php');

class WeixinTest extends WeixinCallback
{
    function OnText($strText, $strUserName)
    {
    	return $strText.WX_EOL.$strText.WX_EOL;	// echo twice
    }
}

function _main()
{
    SqlConnectDatabase();

    $wx = new WeixinTest();
    $wx->Run();
}

    _main();
    
?>
