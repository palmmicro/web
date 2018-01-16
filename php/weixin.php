<?php
require_once('debug.php');

define('WX_EOL', "\r\n");
define('MAX_WX_MSG_LEN', 2048);

define('WX_MSG_TYPE_TEXT', 'text');
define('WX_MSG_TYPE_VOICE', 'voice');
define('WX_MSG_TYPE_IMAGE', 'image');
define('WX_MSG_TYPE_LOCATION', 'location');
define('WX_MSG_TYPE_SHORTVIDEO', 'shortvideo');
define('WX_MSG_TYPE_LINK', 'link');
define('WX_MSG_TYPE_EVENT', 'event');

/*** wechat php test  */
//define your token
define('TOKEN', 'woody1234');

class wechatCallbackapiTest
{
	public function valid()
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
	    if ($strType == WX_MSG_TYPE_TEXT)
	    {
	        $str = WxOnText(trim($postObj->Content), $strUserName);
	    }
	    else if ($strType == WX_MSG_TYPE_VOICE)
	    {
	        $str = WxOnVoice(trim($postObj->Recognition), $strUserName);
	    }
	    else if ($strType == WX_MSG_TYPE_EVENT)
	    {
	        $strContents = trim($postObj->Event);
	        if ($strContents == 'CLICK')
	        {   // 自定义菜单点击事件
	            $str = WxOnEventMenu('', $strUserName);
	        }
	        else
	        {
	            $str = WxOnEvent($strContents, $strUserName);
	        }
	    }
	    else if ($strType == WX_MSG_TYPE_IMAGE)
	    {
	        $str = WxOnImage(trim($postObj->PicUrl), $strUserName);
	    }
	    else if ($strType == WX_MSG_TYPE_SHORTVIDEO)
	    {
	        $str = WxOnShortVideo('', $strUserName);
	    }
	    else if ($strType == WX_MSG_TYPE_LOCATION)
	    {
	        $str = WxOnLocation('', $strUserName);
	    }
	    else if ($strType == WX_MSG_TYPE_LINK)
	    {
	        $str = WxOnLink('', $strUserName);
	    }
	    else
	    {
	        $str = WxOnUnknownType($strType, $strUserName);
	    }
        return $str.WX_DEBUG_VER;
    }
}


?>
