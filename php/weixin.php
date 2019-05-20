<?php
require_once('debug.php');

// 微信公众号公共模板, 返回输入信息
define('WX_DEBUG_VER', '版本878');		

define('WX_EOL', "\r\n");
define('MAX_WX_MSG_LEN', 2048);

define('WX_MSG_TYPE_EVENT', 'event');
define('WX_MSG_TYPE_FILE', 'file');
define('WX_MSG_TYPE_IMAGE', 'image');
define('WX_MSG_TYPE_LINK', 'link');
define('WX_MSG_TYPE_LOCATION', 'location');
define('WX_MSG_TYPE_SHORTVIDEO', 'shortvideo');
define('WX_MSG_TYPE_TEXT', 'text');
define('WX_MSG_TYPE_VOICE', 'voice');

// Account https://blog.csdn.net/zxq1474477147/article/details/53337683
// BLE https://blog.csdn.net/skdev/article/details/51000551

//define your token
define('TOKEN', 'woody1234');

class WeixinCallback
{
	public function Run()
    {
        //valid signature , option
        if ($this->checkSignature())
        {
            $echoStr = $_GET['echostr'];
            if ($echoStr)
            {
                echo $echoStr;
            }
            else
            {
                $this->responseMsg();
            }
        }
    }

    private function responseMsg()
    {
		$postStr = $GLOBALS['HTTP_RAW_POST_DATA'];		//get post data, May be due to the different environments
		if (!empty($postStr))
		{    //extract post data
            libxml_disable_entity_loader(true);     // libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself.
          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            $textTpl = '<xml>
    					<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>';             
           	$msgType = WX_MSG_TYPE_TEXT;
            $contentStr = $this->handleMessage($postObj);
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined('TOKEN')) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
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
	    	$str = $this->OnLink('', $strUserName);
	    	break;
	    	
	    case WX_MSG_TYPE_FILE:
	    	$str = $this->OnFile('', $strUserName);
	    	break;
	    	
	    default:
	    	$str = $this->OnUnknownType($strType, $strUserName);
	    	break;
	    }
        return $str.WX_DEBUG_VER;
    }
    
    function GetDefaultText()
    {
    	return '测试账号'.WX_EOL;
    }

    function GetUnknownText($strContents, $strUserName)
    {
    	$str = $strContents.WX_EOL;
    	$str .= '没有匹配到信息.'.WX_EOL;
    	return $str.$this->GetDefaultText();
    }

    function OnText($strText, $strUserName)
    {
    	return $strText.WX_EOL;	// echo
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
    		return '欢迎订阅, 本账号为自动回复, 请用语音或者键盘输入要查找的内容.'.WX_EOL;

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
