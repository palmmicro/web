<?php
require_once('weixin.php');
//require_once('url.php');
require_once('debug.php');
require_once('stock.php');
require_once('email.php');

require_once('ui/stocktext.php');

//require_once('sql/sqlvisitor.php');
require_once('sql/sqlspider.php');
require_once('sql/sqlweixin.php');

define('WX_DEFAULT_SYMBOL', 'SZ162411');
define('MAX_WX_STOCK', 50);

// ****************************** Wexin support functions *******************************************************

// A股代码正则表达式 ^(?i)s[hz]\d{6}$
function _getMarketMatch($strKey)
{
    $str = $strKey;
    if (IsChineseStockDigit($strKey))
    {
        $str = StockBuildChineseSymbol($strKey);
    }
    else if (substr($strKey, 0, 5) == 'NYSE:')
    {
        $str = substr($strKey, 5);
    }
    else if (substr($strKey, 0, 7) == 'NASDAQ:')
    {
        $str = substr($strKey, 7);
    }
    else if (substr($strKey, 0, 3) == 'HK:')
    {
        $str = substr($strKey, 3);
        if (strlen($str) == 4)
        {
            $str = '0'.$str;
        }
    }
    else if (substr($strKey, 0, 3) == 'SH:')
    {
        $strDigit = substr($strKey, 3);
        if (IsChineseStockDigit($strDigit))
        {
            $str = SHANGHAI_PREFIX.$strDigit;
        }
    }
    else if (substr($strKey, 0, 3) == 'SZ:')
    {
        $strDigit = substr($strKey, 3);
        if (IsChineseStockDigit($strDigit))
        {
            $str = SHENZHEN_PREFIX.$strDigit;
        }
    }
    return $str;
}

function _getExactMatch($strKey)
{
    $strSymbol = _getMarketMatch($strKey);
    if (SqlGetStock($strSymbol))
    {
        return $strSymbol; 
    }
    
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSymbolA() || $sym->IsSymbolH())
    {
    	$ref = new MyStockReference($strSymbol);
    	if ($ref->HasData())	return $strSymbol;
    }
    
    return false;
}

function _wxGetStockArray($strContents)
{
    $strKey = trim($strContents);
    $ar = array();
//  if (!empty($strKey))     // "0" (0 as a string) is considered to be empty
    if (strlen($strKey) > 0)
    {
    	if ($strSymbol = _getExactMatch($strKey))
    	{   // exact match
    		$ar[] = $strSymbol;
    	}
    
    	// check all
    	if ($result = SqlGetAllStock(0, 0)) 
    	{
    		while ($stock = mysql_fetch_assoc($result)) 
    		{
    			$str = $stock['symbol'];
    			if (strstr($str, $strKey) || strstr($stock['name'], $strKey))
    			{
    				$ar[] = $str;
    				if (count($ar) > MAX_WX_STOCK)	break;
    			}
    		}
    		@mysql_free_result($result);
    	}
    }
    return array_unique($ar);
}

function _getAhReferenceText($ref, $hshare_ref)
{
	RefSetExternalLink($ref);
    $str = TextFromAhReference($ref, $hshare_ref);
    return $str;
}

function _getStockReferenceText($ref)
{
	RefSetExternalLink($ref);
    $str = TextFromStockReference($ref);
    return $str;
}

function _getFundReferenceText($ref)
{
	if ($ref->stock_ref)
	{
		RefSetExternalLink($ref->stock_ref);
	}
    $str = TextFromFundReference($ref); 
    return $str;
}

function _wxGetStockText($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $str = false;
    if ($sym->IsSinaFund())     
    {   // IsSinaFund must be called before IsSinaFuture
        $ref = new FundReference($strSymbol);
        $str = _getFundReferenceText($ref); 
    }
    else if ($strFutureSymbol = $sym->IsSinaFuture())
    {
        $ref = new FutureReference($strFutureSymbol);
        $str = _getStockReferenceText($ref); 
    }
    else if ($sym->IsSinaForex())
    {
    	$ref = new ForexReference($strSymbol);
        $str = _getStockReferenceText($ref); 
    }
    else if ($sym->IsEastMoneyForex())
    {
    	$ref = new CnyReference($strSymbol);
        $str = _getStockReferenceText($ref); 
    }
    else if ($sym->IsFundA())
    {
        $ref = StockGetFundReference($strSymbol);
        $str = _getFundReferenceText($ref);
        if (in_arrayLof($strSymbol))
        {
        	$uscny_ref = new CnyReference('USCNY');
	        $str .= _getStockReferenceText($uscny_ref); 
        }
    }
    else
    {
    	if ($ref_ar = StockGetHShareReference($sym))
    	{
    		list($ref, $hshare_ref) = $ref_ar;
			$str = _getAhReferenceText($ref, $hshare_ref);
    	}
        else
        {
        	$ref = new MyStockReference($strSymbol);
        	$str = _getStockReferenceText($ref);
        }
    }
   	if ($str == false)
   	{
   		$str = "($strSymbol:无数据)";
   		DebugString($str);
   		$str .= WX_EOL;
   	}
    return $str;
}

// Try to stock stock information directly from stock data sources
function _wxGetUnknownStockText($strContents)
{
    if (preg_match('/^[A-Z0-9:^.]+$/', $strContents))
    {
        $strSymbol = _getMarketMatch($strContents);
        if ($str = _wxGetStockText($strSymbol))
        {
            return $str.WX_EOL.WX_EOL;
        }
    }
    return false;
}

function _wxEmailDebug($strUserName, $strText, $strSubject)
{   
	$str = '<font color=blue>用户:</font>'.$strUserName;
	$str .= '<br />'.$strText;
	$str .= '<br />'.GetWeixinLink();
    EmailReport($str, $strSubject);
}

function _wxGetStockArrayText($arSymbol)
{
	sort($arSymbol);
    StockPrefetchArrayData($arSymbol);
    $str = '';
    foreach ($arSymbol as $strSymbol)
    {
        if ($strText = _wxGetStockText($strSymbol))
        {
//            DebugString($strText);
            if (strlen($str.$strText.WX_EOL.WX_DEBUG_VER) < MAX_WX_MSG_LEN)
            {
                $str .= $strText.WX_EOL;
            }
            else
            {
                break;
            }
        }
    }
    return $str;
}

function _updateWeixinTables($strText, $strUserName)
{
    SqlCreateVisitorTable(WEIXIN_VISITOR_TABLE);
    if ($strDstId = MustGetSpiderParameterId($strText))
    {
        $strSrcId = MustGetWeixinId($strUserName);
        SqlInsertVisitor(WEIXIN_VISITOR_TABLE, $strDstId, $strSrcId);
    }
}

class WeixinStock extends WeixinCallback
{
	function GetDefaultText()
	{
		return _wxGetStockArrayText(array(WX_DEFAULT_SYMBOL));
	}

	function GetUnknownText($strContents, $strUserName)
	{
		_wxEmailDebug($strUserName, "<font color=green>内容:</font>$strContents", 'Wechat message');
		$str = $strContents.WX_EOL;
		$str .= '本公众号目前只提供股票交易和净值估算自动查询. 因为没有匹配到信息, 此消息内容已经发往support@palmmicro.com邮箱, palmmicro会尽可能用电子邮件回复.'.WX_EOL;
		return $str.$this->GetDefaultText();
	}

	function OnText($strText, $strUserName)
	{
//		DebugString($strText);
		$strText = UrlCleanString($strText);
		_updateWeixinTables($strText, $strUserName);
    
		$strContents = strtoupper($strText);
		$arSymbol = _wxGetStockArray($strContents);
		if (count($arSymbol))
		{
			$str = _wxGetStockArrayText($arSymbol);
		}
		else
		{
			if (($str = _wxGetUnknownStockText($strContents)) == false)
			{
				$str = $this->GetUnknownText($strText, $strUserName);
			}
		}
		return $str;
	}

	function OnEvent($strContents, $strUserName)
	{
		if ($strContents == 'subscribe')
		{
			$str = '欢迎订阅, 本账号为自动回复, 请用语音或者键盘输入要查找的内容. 想聊天的请加QQ群204836363'.WX_EOL;
			$str .= $this->GetDefaultText();
		}
		else if ($strContents == 'unsubscribe')
		{
			$str = '再见';
		}
		else if ($strContents == 'MASSSENDJOBFINISH')
		{	// Mass send job finish
			$str = '收到群发完毕';
		}
		_wxEmailDebug($strUserName, $str, 'Wechat '.$strContents);
		return $str;
	}

	function OnImage($strUrl, $strUserName)
	{
		$strContents = '未知图像信息';
    
		SqlCreateWeixinImageTable();
		$strOpenId = MustGetWeixinId($strUserName);
		SqlInsertWeixinImage($strOpenId);
		if ($str = SqlGetWeixinImageNow($strOpenId))
		{
			$img = url_get_contents($strUrl);    
			$size = strlen($img);
			$strFileName = DebugGetImageName($str); 
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

function _main()
{
    SqlConnectDatabase();

    $wx = new WeixinStock();
    $wx->Run();
}

    _main();
    
?>
