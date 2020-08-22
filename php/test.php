<?php
require_once('debug.php');
require_once('account.php');
require_once('stock.php');

require_once('sql/_sqltest.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlvisitor.php');
require_once('sql/sqlstockdaily.php');

define('DEBUG_UTF8_BOM', "\xef\xbb\xbf");

// http://www.todayir.com/en/index.php HSFML25

function _debug_dividend($strSymbol)
{
	if ($arMatch = SinaGetStockDividendA($strSymbol))
	{
		$iVal = count($arMatch);
	
		DebugVal($iVal);
		for ($j = 0; $j < $iVal; $j ++)
		{
			DebugString($arMatch[$j][0]);
			for ($i = 1; $i < 9; $i ++) DebugString($arMatch[$j][$i]);
		}
	}
}

function TestCmdLine()
{
	DebugString('cmd line test '.UrlGetQueryString());
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$strSrc = UrlGetQueryDisplay('src', 'yahoo');
    	$ref = new MyStockReference($strSymbol);
    	DebugString('Stock ID '.$ref->GetStockId());
    	$fStart = microtime(true);
    	switch ($strSrc)
    	{
    	case 'yahoo':		
    		$str = YahooGetWebData($ref);
    		break;
    	
    	case 'sina':
    		_debug_dividend($strSymbol);
			break;
    	}
    	if (empty($str))	$str = '(Not found)';
    	DebugString($strSymbol.':'.$str.DebugGetStopWatchDisplay($fStart));
    }
}

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

	file_put_contents(DebugGetFile(), DEBUG_UTF8_BOM.'Start debug:'.PHP_EOL);
	DebugString($_SERVER['DOCUMENT_ROOT']);
	DebugString(phpversion());
	echo strval(rand()).' Hello, world!';
	
	$acct = new Account();
	TestCmdLine();
/*	
	$ip_sql = $acct->GetIpSql();
	$sql = new PageCommentSql();
	if ($result = SqlGetBlogComment(false, 0, 0)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			$strIp = $record['ip'];
			if (filter_valid_ip($strIp))
			{
				if ($ip_sql->InsertIp($strIp))	DebugString('新IP: '.$strIp);
				else	DebugString('老IP: '.$strIp);
				
				list($strDate, $strTime) = explode(' ', $record['modified']);
				DebugString($strDate.' '.$strTime);
				DebugString($record['comment']);
				
				$sql->InsertPageComment($record['blog_id'], $record['member_id'], $record['comment'], $ip_sql->GetId($strIp), $strDate, $strTime);
			}
		}
		@mysql_free_result($result);
	}
*/	
//	WriteForexDataFromFile();
	phpinfo();
?>
