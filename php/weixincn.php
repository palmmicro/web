<?php
require_once('weixin.php');
require_once('debug.php');
require_once('stock.php');
require_once('ui/stocktext.php');

define('MAX_WX_STOCK', 10);

// ****************************** Wexin support functions *******************************************************

function _wxGetStockArray($strKey, $sql)
{
    $ar = array();
    
//  if (!empty($strKey))     // "0" (0 as a string) is considered to be empty
	$iLen = strlen($strKey); 
    if ($iLen > 0)
    {
/*    	$bPinYin = false;
    	if ($iLen == 4)
    	{
    		if (preg_match('#[A-Za-z]+#', $strKey))
    		{
    			DebugString('拼音简称:'.$strKey);
    			$gb_sql = new GB2312Sql();
    			$bPinYin = true;
    		}
    	}
*/    	
    	if ($result = $sql->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strSymbol = $record['symbol'];
    			$strName = $record['name'];
    			if ((stripos($strSymbol, $strKey) !== false) 
    				|| (stripos($strName, $strKey) !== false)
//    				|| ($bPinYin && (stripos($gb_sql->GetStockPinYinName($strName), $strKey) !== false))
    				)
    			{
    				$ar[] = $strSymbol;
    				if (count($ar) >= MAX_WX_STOCK)	
    					break;
    			}
    		}
    		@mysql_free_result($result);
    	}
    }
    return $ar;
}

function _wxGetStockText($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $str = false;
    if ($sym->IsSinaFund())     
    {   // IsSinaFund must be called before IsSinaFuture
        $ref = new FundReference($strSymbol);
        $str = TextFromFundReference($ref); 
    }
    else if ($sym->IsSinaFuture())
    {
        $ref = new FutureReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsSinaForex())
    {
    	$ref = new ForexReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsEastMoneyForex())
    {
    	$ref = new CnyReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsFundA())
    {
        $ref = StockGetFundReference($strSymbol);
        $str = TextFromFundReference($ref);
        if (in_arrayQdii($strSymbol))
        {
        	$uscny_ref = new CnyReference('USCNY');
	        $str .= WX_EOL.TextFromStockReference($uscny_ref); 
	        
	        $etf_ref = new MyStockReference(QdiiGetEstSymbol($strSymbol));
	        $str .= WX_EOL.TextFromStockReference($etf_ref); 
	        
	        if ($strFutureSymbol = QdiiGetFutureSymbol($strSymbol))
	        {
	        	$future_ref = new FutureReference($strFutureSymbol);
	        	$str .= WX_EOL.TextFromStockReference($future_ref); 
	        }
	    }
    }
    else
    {
       	$ref = new MyStockReference($strSymbol);
       	$str = TextFromStockReference($ref);
       	
    	$ab_sql = new AbPairSql();
    	if ($ab_sql->GetPairSymbol($strSymbol))
    	{
    		$ab_ref = new AbPairReference($strSymbol);
			$str .= TextFromAbReference($ab_ref);
    	}
    	else if ($strSymbolA = $ab_sql->GetSymbol($strSymbol))
    	{
    		$ab_ref = new AbPairReference($strSymbolA);
			$str .= TextFromAbReference($ab_ref, false);
    	}
    	
    	if ($ref_ar = StockGetHShareReference($sym))
    	{
    		list($dummy, $hshare_ref) = $ref_ar;
			$str .= TextFromAhReference($hshare_ref);
    	}
    }
   	if ($str == false)
   	{
   		DebugString("($strSymbol:无数据)");
   		return false;
   	}
   	
/*
	if ($strSymbol == 'SZ162411')
	{
		$str .= '2019年9月20日星期五, XOP季度分红除权. 因为现在采用XOP净值替代SPSIOP做华宝油气估值, 23日的估值不准, 要等华宝油气20日实际净值出来自动校准后恢复正常.'.WX_EOL;
	}*/
    return $str;
}

function _wxDebug($strUserName, $strText, $strSubject)
{   
	$str = '<font color=blue>用户:</font>'.$strUserName;
	$str .= '<br />'.$strText;
	$str .= '<br />'.GetWeixinLink();
    trigger_error($strSubject.'<br />'.$str);
}

class WeixinStock extends WeixinCallback
{
    var $stock_sql;

    function WeixinStock() 
    {
    	SqlConnectDatabase();

	    $this->stock_sql = new StockSql();
    }

    function GetStockSql()
    {
    	return $this->stock_sql;
    }
    
    function AllowCurl()
    {
    	return true;
    }
    
	function _getStockArrayText($arSymbol, $str)
	{
		$iMaxLen = MAX_WX_MSG_LEN - strlen($this->GetVersion());
		StockPrefetchArrayData($arSymbol);
		
		foreach ($arSymbol as $strSymbol)
		{
			if ($strText = _wxGetStockText($strSymbol))
			{
				if (strlen($str.$strText.WX_EOL) < $iMaxLen)
				{
					$str .= $strText.WX_EOL;
				}
				else
				{
					break;
				}
			}
			else
			{	// something is wrong, break to avoid timeout
				break;
			}
		}
//		DebugVal(strlen($str));
		return $str;
	}

    function GetVersion()
    {
    	return WX_DEBUG_VER.' '.GetWeixinDevLink('使用说明');
    }

	function GetUnknownText($strContents, $strUserName)
	{
		_wxDebug($strUserName, "<font color=green>内容:</font>$strContents", 'Wechat message');
		$str = $strContents.WX_EOL;
		$str .= '本公众号目前只提供部分股票交易和净值估算自动查询。因为没有匹配到信息，此消息内容已经发往support@palmmicro.com邮箱。Palmmicro会尽快在公众号上回复。'.WX_EOL;
		return $str;
	}

	function OnText($strText, $strUserName)
	{
//		DebugString($strText);
		$strText = str_replace('【', '', $strText);
		$strText = str_replace('】', '', $strText);
		$strText = str_replace('，', '', $strText);
		$strText = str_replace(',', '', $strText);
		$strText = str_replace('。', '', $strText);
		$strText = str_replace('.', '', $strText);
		$strText = trim($strText);

        if (stripos($strText, 'Q群') !== false)			return '本公众号不再提供群聊技术支持，请在公众号文章下公开留言。'.WX_EOL;
        else if (strpos($strText, '商务合作') !== false)	return '请把具体合作内容和方式发往woody@palmmicro.com邮箱。'.WX_EOL;
        else if (strpos($strText, '广发原油') !== false)	return '6月19日公众号文章标题写错了，应该是广发石油(162719)。'.WX_EOL;
/*
        if (_ConnectDatabase() == false)
        {
        	return '服务器繁忙, 请稍后再试.'.WX_EOL;
        }
*/
		$strText = SqlCleanString($strText);

		$arSymbol = _wxGetStockArray($strText, $this->GetStockSql());
		if ($iCount = count($arSymbol))
		{
			if ($iCount > 1)
			{
				$str = '(至少发现'.strval($iCount).'个匹配)';
//				DebugString($strText.$str);
				$str .= WX_EOL.WX_EOL;
			}
			else
			{
				$str = '';
			}
			$str = $this->_getStockArrayText($arSymbol, $str);
		}
		else
		{
			$str = $this->GetUnknownText($strText, $strUserName);
		}
		
		return $str;
	}

	function OnEvent($strContents, $strUserName)
	{
		switch ($strContents)
		{
		case 'subscribe':
			$str = '欢迎订阅, 本账号为自动回复, 请用语音或者键盘输入要查找的内容.';
			break;
			
		case 'unsubscribe':
			$str = '再见';
			break;
			
		case 'MASSSENDJOBFINISH':
			$str = '收到群发完毕';		// Mass send job finish
			break;
			
		default:
			$str = '(未知Event)';
			break;
		}
		_wxDebug($strUserName, $str, 'Wechat '.$strContents);
		return $str.WX_EOL;
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
