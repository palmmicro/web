<?php
require('_tgprivate.php');
require_once('debug.php');
require_once('stockbot.php');

// 电报公共模板, 返回输入信息
define('TG_DEBUG_VER', '版本001');		

define('BOT_EOL', "\r\n");
define('MAX_BOT_MSG_LEN', 2048);

define('TG_API_URL', 'https://api.telegram.org/bot'.TG_TOKEN.'/');

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

	function _sendText($strText, $chat_id) 
	{
        url_get_contents(TG_API_URL.'sendmessage?text='.urlencode($strText).'&chat_id='.$chat_id);        //valid signature , option
	}
	
	function _processMessage($message) 
	{
		// process incoming message
		$message_id = $message['message_id'];
		$chat_id = $message['chat']['id'];
		if (isset($message['text'])) 
		{	// incoming text message
			$text = $message['text'];
			if (strpos($text, "/start") === 0) 
			{
//				apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array('keyboard' => array(array('Hello', 'Hi')), 'one_time_keyboard' => true, 'resize_keyboard' => true)));
			} 
/*			else if ($text === "Hello" || $text === "Hi") 
			{
//				apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
			}*/ 
			else if (strpos($text, "/stop") === 0) 
			{	// stop now
			} 
			else 
			{
//				$name = $message['from']['first_name'];
//				$strText = $text.' '.$name;
		        $strText = StockBotGetStr($text, $this->GetVersion());
				$this->_sendText($strText, $chat_id);
//			      apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Cool'));
			}
		}
		else 
		{
//			apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
			$this->_sendText('只能回复文本消息', $chat_id);
		}
	}		

	public function Run()
    {
    	$content = file_get_contents('php://input');
    	$update = json_decode($content, true);
//    	DebugPrint($update);

    	if (!$update) 
    	{  // receive wrong update, must not happen
    		exit;
    	}

    	if (isset($update['message'])) 
    	{
    		$this->_processMessage($update['message']);
    	}
    }
}

class TelegramStock extends TelegramCallback
{
    function TelegramStock() 
    {
    	SqlConnectDatabase();
		InitGlobalStockSql();
    }

    function AllowCurl()
    {
    	return true;
    }
}

    $acct = new TelegramStock();
    $acct->Run();
//    $acct->SetCallback();

?>
