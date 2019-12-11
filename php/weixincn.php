<?php
require_once('weixin.php');
//require_once('url.php');
require_once('debug.php');
require_once('stock.php');

require_once('ui/stocktext.php');

//require_once('sql/sqlvisitor.php');
require_once('sql/sqlweixin.php');

define('WX_DEFAULT_SYMBOL', 'SZ162411');
define('MAX_WX_STOCK', 31);

// ****************************** Wexin support functions *******************************************************

function _wxGetStockArray($strContents)
{
    $strKey = trim($strContents);
    $ar = array();
//  if (!empty($strKey))     // "0" (0 as a string) is considered to be empty
    if (strlen($strKey) > 0)
    {  	// check all
    	$sql = new StockSql();
    	if ($result = $sql->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$str = $record['symbol'];
    			if ((stripos($str, $strKey) !== false) || (stripos($record['name'], $strKey) !== false))
    			{
    				$ar[] = $str;
    				if (count($ar) > MAX_WX_STOCK)	break;
    			}
    		}
    		@mysql_free_result($result);
    	}
    }
    return $ar;
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
    else if ($sym->IsSinaFuture())
    {
        $ref = new FutureReference($strSymbol);
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
       	$ref = new MyStockReference($strSymbol);
       	$str = _getStockReferenceText($ref);
       	
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
   		$str = "($strSymbol:无数据)";
   		DebugString($str);
   		$str .= WX_EOL;
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

function _updateWeixinTables($strText, $strUserName)
{
    SqlCreateVisitorTable(WEIXIN_VISITOR_TABLE);
    
	$text_sql = new WeixinTextSql();
	$text_sql->InsertKey($strText);
	$strDstId = $text_sql->GetId($strText);

	$sql = new WeixinSql();
	$sql->InsertUser($strUserName);
	$strSrcId = $sql->GetId($strUserName);
	
    SqlInsertVisitor(WEIXIN_VISITOR_TABLE, $strDstId, $strSrcId);
}

class WeixinStock extends WeixinCallback
{
	function _getStockArrayText($arSymbol, $str = '')
	{
		$strVer = $this->GetVersion();
		sort($arSymbol);
		StockPrefetchArrayData($arSymbol);
		foreach ($arSymbol as $strSymbol)
		{
			if ($strText = _wxGetStockText($strSymbol))
			{
				if (strlen($str.$strText.WX_EOL.$strVer) < MAX_WX_MSG_LEN)
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

    function GetVersion()
    {
    	return WX_DEBUG_VER.' '.GetInternalLink('/woody/blog/palmmicro/20161014cn.php', '使用说明');
    }
    
	function GetDefaultText()
	{
		return $this->_getStockArrayText(array(WX_DEFAULT_SYMBOL));
	}

	function GetUnknownText($strContents, $strUserName)
	{
		_wxDebug($strUserName, "<font color=green>内容:</font>$strContents", 'Wechat message');
		$str = $strContents.WX_EOL;
		$str .= '本公众号目前只提供部分股票交易和净值估算自动查询. 因为没有匹配到信息, 此消息内容已经发往support@palmmicro.com邮箱, palmmicro会尽快在公众号上回复.'.WX_EOL;
		return $str.$this->GetDefaultText();
	}

	function GetQqGroupText()
	{
		$str = '华宝油气套利群5: <a href="https://jq.qq.com/?_wv=1027&k=58jfWg5">552032726</a>'.WX_EOL;
    	$str .= GetInternalLink('/woody/image/group5.png', '二维码链接').WX_EOL;
		return $str;
	}
	
	function OnText($strText, $strUserName)
	{
//		DebugString($strText);
		$strText = trim($strText);
//		$strText = trim($strText, ',?:.，？：。');
		$strText = rtrim($strText, '。');
		$strText = UrlCleanString($strText);
		_updateWeixinTables($strText, $strUserName);
    
        if (stripos($strText, 'q群') !== false)	return $this->GetQqGroupText();

		$arSymbol = _wxGetStockArray($strText);
		if ($iCount = count($arSymbol))
		{
			$str = ($iCount > 1) ? '至少发现'.strval($iCount).'个匹配'.WX_EOL : ''; 
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
		if ($strContents == 'subscribe')
		{
			$str = '欢迎订阅, 本账号为自动回复, 请用语音或者键盘输入要查找的内容.'.WX_EOL;
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
		_wxDebug($strUserName, $str, 'Wechat '.$strContents);
		return $str;
	}

	function OnImage($strUrl, $strUserName)
	{
		$strContents = '未知图像信息';
    
		$img = url_get_contents($strUrl);    
		$size = strlen($img);
		$strFileName = DebugGetImageName($strUserName); 
		$fp = @fopen($strFileName, 'w');  
		fwrite($fp, $img);  
		fclose($fp);  
//      unset($img, $url);

        $strLink = GetInternalLink($strFileName, $strFileName);
        $strContents .= "(已经保存到{$strLink})";
    
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
