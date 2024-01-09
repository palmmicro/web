<?php
require('_wxprivate.php');

// 微信公众号公共模板, 返回输入信息
define('WX_DEBUG_VER', '版本172');		

define('BOT_EOL', "\r\n");
define('MAX_BOT_MSG_LEN', 2048);

define('WX_MSG_TYPE_EVENT', 'event');
define('WX_MSG_TYPE_FILE', 'file');
define('WX_MSG_TYPE_IMAGE', 'image');
define('WX_MSG_TYPE_LINK', 'link');
define('WX_MSG_TYPE_LOCATION', 'location');
define('WX_MSG_TYPE_SHORTVIDEO', 'shortvideo');
define('WX_MSG_TYPE_TEXT', 'text');
define('WX_MSG_TYPE_VOICE', 'voice');

class WeixinCallback
{
	public function Run()
    {
        //valid signature , option
        if ($this->checkSignature())
        {
            if (isset($_GET['echostr']))
            {
                echo $_GET['echostr'];
            }
            else
            {
                $this->responseMsg();
            }
        }
    }
    
    private function responseMsg()
    {
//		$postStr = $GLOBALS['HTTP_RAW_POST_DATA'];		//get post data, May be due to the different environments
		$postStr = file_get_contents('php://input');
		if (!empty($postStr))
		{    //extract post data
            libxml_disable_entity_loader(true);     // libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself.
          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
          	if ($postObj === false)	return;
          	
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = GetNowTick();
//						<FuncFlag>0</FuncFlag>
            $textTpl = '<xml>
    					<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>';             
           	$msgType = WX_MSG_TYPE_TEXT;
            $contentStr = $this->handleMessage($postObj);
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }
    }
		
	private function checkSignature()
	{
        if (!defined('WX_TOKEN')) 
        {
            throw new Exception('WX_TOKEN is not defined!');
        }
        
        if (($signature = UrlGetQueryValue('signature')) == false)	return false;
        if (($timestamp = UrlGetQueryValue('timestamp')) == false)	return false;
        if (($nonce = UrlGetQueryValue('nonce')) == false)			return false;
        		
		$ar = array(WX_TOKEN, $timestamp, $nonce);
		sort($ar, SORT_STRING);
		$str = implode($ar);
		return (sha1($str) == $signature) ? true : false;
	}

	private function handleMessage($postObj)
	{
	    $strUserName = $postObj->FromUserName;
	    $strType = $postObj->MsgType;
	    switch ($strType)
	    {
	    case WX_MSG_TYPE_TEXT:
	    	$str = $this->OnText(trim($postObj->Content), $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_VOICE:
	    	$str = $this->OnVoice(trim($postObj->Recognition), $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_EVENT:
	        $strContents = trim($postObj->Event);
	        if ($strContents == 'CLICK')
	        {   // 自定义菜单点击事件
	            $str = $this->OnEventMenu('', $strUserName);
	        }
	        else
	        {
	            $str = $this->OnEvent($strContents, $strUserName);
	        }
	        break;
	    
	    case WX_MSG_TYPE_IMAGE:
	    	$str = $this->OnImage(trim($postObj->PicUrl), $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_SHORTVIDEO:
	    	$str = $this->OnShortVideo('', $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_LOCATION:
	        $str = $this->OnLocation('', $strUserName);
	        break;
	        
	    case WX_MSG_TYPE_LINK:
	    	$str = $this->OnLink(trim($postObj->Url), $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_FILE:
	    	$str = $this->OnFile('', $strUserName);
	    	break;
	    	
	    default:
	    	$str = $this->OnUnknownType($strType, $strUserName);
	    	break;
	    }
        return $str.$this->GetVersion();
    }
    
    function GetVersion()
    {
    	return WX_DEBUG_VER;
    }
    
    function GetUnknownText($strContents, $strUserName)
    {
    	$str = $strContents.BOT_EOL;
    	$str .= '没有匹配到信息.';
    	return $str;
    }

    function OnText($strText, $strUserName)
    {
    	return $strText.BOT_EOL;	// echo
    }

    function OnVoice($strContents, $strUserName)
    {
    	if (strlen($strContents) > 0)
    	{
    		return $this->OnText($strContents, $strUserName);
    	}
    	else
    	{
    		return $this->GetUnknownText('未知语音', $strUserName);
    	}
    }

    function OnEvent($strContents, $strUserName)
    {
    	switch ($strContents)
    	{
    	case 'subscribe':
    		return '欢迎订阅, 本账号为自动回复, 请用语音或者键盘输入要查找的内容.'.BOT_EOL;

    	case 'unsubscribe':
    		return '再见';

    	case 'MASSSENDJOBFINISH':		// Mass send job finish
    		return '收到群发完毕';
    	}
    	return '未知'.$strContents;
    }

    function OnEventMenu($strMenu, $strUserName)
    {
    	return $this->GetUnknownText('未知自定义菜单点击事件', $strUserName);
    }

    function OnImage($strUrl, $strUserName)
    {
    	return $this->GetUnknownText('未知图像', $strUserName);
    }

    function OnShortVideo($strContents, $strUserName)
    {
    	return $this->GetUnknownText('未知小视频', $strUserName);
    }

    function OnLocation($strContents, $strUserName)
    {
    	return $this->GetUnknownText('未知位置', $strUserName);
    }

    function OnLink($strContents, $strUserName)
    {
    	DebugString($strContents);
    	return $this->GetUnknownText('未知链接', $strUserName);
    }

    function OnFile($strContents, $strUserName)
    {
    	return $this->GetUnknownText('未知文件', $strUserName);
    }

    function OnUnknownType($strType, $strUserName)
    {
    	return $this->GetUnknownText('未知信息类型'.$strType, $strUserName);
    }
}

?>
