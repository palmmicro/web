<?php
require_once('weixin.php');
require_once('stockbot.php');

function _wxDebug($strUserName, $strText, $strSubject)
{   
	$str = GetInfoElement('用户：').$strUserName;
	$str .= '<br />'.$strText;
	$str .= '<br />'.GetWeixinLink();
    trigger_error($strSubject.'<br />'.$str);
}

function _wxEmailInfo()
{
	return '发往'.ADMIN_EMAIL.'邮箱。(目前邮箱系统异常，请在雪球上联系woody1234)'.BOT_EOL;
}

class WeixinStock extends WeixinCallback
{
    function WeixinStock() 
    {
    	SqlConnectDatabase();
    }

    function GetVersion()
    {
    	return WX_DEBUG_VER.' '.GetDevGuideLink('weixin');
    }

	function GetUnknownText($strContents, $strUserName)
	{
		_wxDebug($strUserName, GetRemarkElement('内容：').$strContents, 'Wechat message');
		$str = $strContents.BOT_EOL;
		$str .= '本公众号目前只提供部分股票交易和净值估算自动查询。因为没有匹配到信息，此消息内容已经'._wxEmailInfo();
		return $str;
	}

	function OnText($strText, $strUserName)
	{
        if (stripos($strText, 'Q群') !== false)			return '本公众号不再提供群聊技术支持，有问题请'._wxEmailInfo();
        else if (strpos($strText, '商务合作') !== false)	return '请把具体合作内容和方式'._wxEmailInfo();
        else if (strpos($strText, '广发原油') !== false)	return '2020年6月19日公众号文章标题写错了，应该是广发石油(162719)。'.BOT_EOL;
        
        if ($str = StockBotGetStr($strText, $this->GetVersion()))		return $str;
		return $this->GetUnknownText($strText, $strUserName);
	}

	function OnEvent($strContents, $strUserName)
	{
		switch ($strContents)
		{
		case 'subscribe':
			$str = '欢迎订阅。本账号为自动回复，不提供人工咨询服务。请用语音或者键盘输入要查找的内容，例如【162411】或者【中概】。';
			break;
			
		case 'unsubscribe':
			$str = '再见';
			break;
			
		case 'MASSSENDJOBFINISH':
			$str = '收到群发完毕';		// Mass send job finish
			break;
			
		default:
			$str = '(未知Event)';
			_wxDebug($strUserName, $str, 'Wechat '.$strContents);
			break;
		}
		return $str.BOT_EOL;
	}

	function OnImage($strUrl, $strUserName)
	{
		$strContents = '未知图像信息';
    
		if ($img = url_get_contents($strUrl))
		{
			$size = strlen($img);
			$strFileName = DebugGetImageName($strUserName); 
			$fp = @fopen($strFileName, 'w');  
			fwrite($fp, $img);  
			fclose($fp);  
//      	unset($img, $url);

        	$strLink = GetInternalLink($strFileName, $strFileName);
        	$strContents .= "(已经保存到{$strLink})";
        }
    
        return $this->GetUnknownText($strContents, $strUserName);
    }
}

    $acct = new WeixinStock();
    $acct->Run();
?>
