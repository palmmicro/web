<?php
require('_tgprivate.php');
require_once('stockbot.php');

// 电报公共模板, 返回输入信息
define('TG_DEBUG_VER', '版本010');		

define('BOT_EOL', "\r\n");
define('MAX_BOT_MSG_LEN', 2048);

define('TG_API_URL', 'https://api.telegram.org/bot'.TG_TOKEN.'/');
define('TG_ADMIN_CHAT_ID', '992671436');		// @sz152
define('TG_CAST_CHAT_ID', '-1001346320717');	// @palmmicrocast

class TelegramCallback
{
    function GetVersion()
    {
    	return TG_DEBUG_VER;
    }
    
	function SetCallback()
	{
		$strUrl = TG_API_URL.'setWebhook?url='.UrlGetServer().'/php/telegram.php';
		if ($str = url_get_contents($strUrl))
		{
			echo $str;
		}
	}

	function DirectReply($method, $parameters) 
	{
		if (!is_string($method))			return false; 
		if (!$parameters) 		    		$parameters = array();
		else if (!is_array($parameters))	return false;

		$parameters['method'] = $method;
		$payload = json_encode($parameters);
		header('Content-Type: application/json');
		header('Content-Length: '.strlen($payload));
		echo $payload;
		return true;
	}

	function ReplyText($strText, $strMessageId, $strChatId) 
	{
		$this->DirectReply('sendMessage', array('chat_id' => $strChatId, 'reply_to_message_id' => $strMessageId, 'text' => $strText));
	}
	
	function _sendText($strText, $chat_id) 
	{
        url_get_contents(TG_API_URL.'sendMessage?text='.urlencode($strText).'&chat_id='.$chat_id);        //valid signature , option
	}

	function Debug($strDebug)
	{
		$this->_sendText($strDebug, TG_ADMIN_CHAT_ID);
//		$this->_sendText($strDebug, TG_CAST_CHAT_ID);
	}
	
    function OnText($strText, $strMessageId, $strChatId)
    {
		$this->_sendText($strText, $strChatId);
    }

	function _processMessage($message) 
	{
		// process incoming message
		$message_id = $message['message_id'];
		$chat_id = $message['chat']['id'];
		if (isset($message['text'])) 
		{	// incoming text message
			$text = $message['text'];
			if (substr($text, 0, 1) == '/')
			{
				$strCmd = trim(ltrim($text, '/'));
				switch ($strCmd)
				{
				case 'start':
//					apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array('keyboard' => array(array('Hello', 'Hi')), 'one_time_keyboard' => true, 'resize_keyboard' => true)));
					break;
				
				case 'stop':	// stop now
					break;
					
				default:
					$this->OnText($strCmd, $message_id, $chat_id);
					break;
				}
			} 
			else 
			{
//				$name = $message['from']['first_name'];
//				$strText = $text.' '.$name;
				$this->OnText($text, $message_id, $chat_id);
			}
		}
		else 
		{
//			apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
//			$this->_sendText('只能回复文本消息', $chat_id);
		}
	}		

	public function Run()
    {
    	$content = file_get_contents('php://input');
    	if ($update = json_decode($content, true))
    	{
//    		DebugPrint($update);
    		if (isset($update['message'])) 
    		{
    			$this->_processMessage($update['message']);
    		}
    	}
    }
}

class TelegramStock extends TelegramCallback
{
    function TelegramStock() 
    {
    	SqlConnectDatabase();
    }

    function OnText($strText, $strMessageId, $strChatId)
    {
    	$strVersion = $this->GetVersion();
        if ($str = StockBotGetStr($strText, $strVersion))
        {
			$str .= $strVersion; 
        	$this->ReplyText($str, $strMessageId, $strChatId);
        }
        else
        {
        	$this->Debug('未知查询：'.$strText);
        }
    }
}

    $acct = new TelegramStock();
    $acct->Run();
//    $acct->SetCallback();

?>
