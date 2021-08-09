<?php
require_once('debug.php');
require_once('account.php');
require_once('stock.php');
//require_once('stocktrans.php');

//require_once('stock/csindex.php');

require_once('sql/sqlblog.php');
require_once('sql/sqlvisitor.php');
//require_once('sql/sqlkeystring.php');

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
/*
function TestModifyTransactions($strGroupId, $strSymbol, $strNewSymbol)
{
	$sql = new StockGroupItemSql($strGroupId);
	$strGroupItemId = $sql->GetId(SqlGetStockId($strSymbol));
	$strNewGroupItemId = $sql->GetId(SqlGetStockId($strNewSymbol));
	$fUshkd = SqlGetUshkd();
	DebugVal($fUshkd);
    if ($result = $sql->GetAllStockTransaction()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	if ($strGroupItemId == $record['groupitem_id'])
        	{
//        		DebugPrint($record);
//        		$sql->trans_sql->Update($record['id'], $strNewGroupItemId, $record['quantity'], $record['price'], $record['fees'], $record['remark'].$strSymbol);
				$strQuantity = strval(10 * intval($record['quantity']));
				$strPrice = strval(floatval($record['price']) * $fUshkd / 10.0);
				$strFees = strval(floatval($record['fees']) * $fUshkd);
        		$sql->trans_sql->Update($record['id'], $strNewGroupItemId, $strQuantity, $strPrice, $strFees, $record['remark']);
        	}
        }
        @mysql_free_result($result);
    }
   	UpdateStockGroupItem($strGroupId, $strGroupItemId);
}
*/
	$acct = new Account();

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
//    EchoInsideHead();

	file_put_contents(DebugGetFile(), DEBUG_UTF8_BOM.'Start debug:'.PHP_EOL);
	DebugString($_SERVER['DOCUMENT_ROOT']);
	DebugString(phpversion());
	echo strval(rand()).' Hello, world!<br />';
	
	TestCmdLine();
	DebugClearPath('csv');
	DebugClearPath('image');

    $his_sql = GetStockHistorySql();
    $iCount = $his_sql->DeleteClose();
	if ($iCount > 0)	DebugVal($iCount, 'Zero close data'); 
//    $iCount = $his_sql->DeleteInvalidDate();		// this can be very slow!
//	if ($iCount > 0)	DebugVal($iCount, 'Invalid or older date'); 
	
//	$sql = new CommonPhraseSql();
//	CsindexGetData();
/*
	$strUrl = 'http://query.sse.com.cn/etfDownload/downloadETF2Bulletin.do?etfType=087';
   	if ($str = url_get_contents($strUrl))
    {
   		DebugString($str);
   	}
*/	

//	TestModifyTransactions('1831', 'CHU', '00762');
//	TestModifyTransactions('1376', 'UWT', 'USO');

	phpinfo();
?>
