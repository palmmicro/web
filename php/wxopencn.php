<?php
require_once('weixin.php');
require_once('sql.php');

/*
微信号:  gh_8cc21bca9f7a  
appID wxd82dc9182c3ee1ac
appsecret d843db031f2131f72ae12c346ae0cda0
*/

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
