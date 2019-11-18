<?php
require_once('debug.php');
require_once('account.php');
require_once('stock.php');
require_once('stock/ftstock.php');

require_once('sql/_sqltest.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlvisitor.php');
require_once('sql/sqlstockdaily.php');

// http://www.todayir.com/en/index.php HSFML25

function _debug_dividend($strSymbol)
{
	$arMatch = SinaGetStockDividendA($strSymbol);
	$iVal = count($arMatch);
	
    DebugVal($iVal);
    for ($j = 0; $j < $iVal; $j ++)
    {
        DebugString($arMatch[$j][0]);
        for ($i = 1; $i < 9; $i ++) DebugString($arMatch[$j][$i]);
    }
}

function _get_dividend($strSymbol)
{
	$arMatch = SinaGetStockDividendA($strSymbol);
	$iVal = count($arMatch);
	if ($iVal > 0)
	{
	    $j = 0;
	    $strStatus = $arMatch[$j][5];
	    $strDividend = $arMatch[$j][4];
	    if ($strStatus == '预案')
	    {
	        return floatval($strDividend) / 10.0; 
	    }
	    else if ($strStatus == '实施')
	    {
	        return floatval($strDividend) / (10.0 + floatval($arMatch[$j][3]) + floatval($arMatch[$j][2])); 
	    }
	    else if ($strStatus == '不分配')
	    {
	        return 0.0;
	    }
	}
	return -1.0;
}

function test_stock_dividend()
{
	$arSymbolData = SinaGetAllStockArrayA();
	$arOutput = array();
    foreach ($arSymbolData as $strSymbol => $arData)
    {
        $fPer = floatval($arData['per']);
        $fPb = floatval($arData['pb']);
        if ($fPer > 0.0 && $fPer < 10.0 && $fPb < 10.0)
        {
            set_time_limit(0);
            $fPrice = floatval($arData['trade']);
            if ($fPrice < 0.0001)   $fPrice = floatval($arData['settlement']);
            
//            $fDividend = _get_dividend($strSymbol);
            $fDividend = $fPrice / $fPer;

            $fDividendRate = 0.0;
            if ($fDividend > 0.0 && $fPrice > 0.0)   $fDividendRate = $fDividend / $fPrice;
            $arOutput[$strSymbol] = $fDividendRate; 
        }
    }
    
    arsort($arOutput);
    DebugString('总数: '.strval(count($arOutput)));
    DebugString('代码 名称 当前交易价格 价格涨跌百分比 交易时间 PB PE 骑姐分红指标');
    foreach ($arOutput as $strSymbol => $fDividendRate)
    {
        $arData = $arSymbolData[$strSymbol];
        DebugString($strSymbol.' '.$arData['name'].' '.$arData['trade'].' '.$arData['changepercent'].' '.$arData['ticktime'].' '.$arData['pb'].' '.$arData['per'].' '.strval_round($fDividendRate, 4));
    }
}

function _checkBlogTable()
{
	$ar = array();
	$sql = new BlogSql();
//	$sql->AlterTable('UNIQUE ( `uri`, `member_id` )');
    if ($result = $sql->GetAll()) 
    {   
    	$iTotal = 0;
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strId = $record['id'];
        	$strUri = $record['uri'];
        	$strMemberId = $record['member_id'];
        	if ((UrlIsValid($strUri) == false) || ($strMemberId != AcctGetMemberIdFromBlogUri($strUri)))          		             
            {
            	$ar[] = $strId;
            	$iCount = SqlDeleteVisitorByBlogId($strId);
            	DebugString($strMemberId.' '.$strUri.' '.strval($iCount));
            	$iTotal ++;
            }
        }
        @mysql_free_result($result);
        DebugVal($iTotal, 'BlogSql');
    }

	foreach ($ar as $strId)
	{
		$sql->DeleteById($strId);
	}
}

function SysInit()
{
	if (SqlConnectDatabase())
	{
	    DebugString('connect database ok');
	}
	
//	_checkBlogTable();
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
    	
    	case 'ft':
    		$str = TestFtStock($strSymbol);
    		break;
    		
    	case 'sina':
//    		_debug_dividend($strSymbol);
			$str = TestSinaStockHistory($strSymbol);
			break;
    	}
    	if (empty($str))	$str = '(Not found)';
    	DebugString($strSymbol.':'.$str.DebugGetStopWatchDisplay($fStart));
    }
}

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    DebugClear();
	DebugString($_SERVER['DOCUMENT_ROOT']);
	DebugString(phpversion());
	SysInit();
	echo strval(rand()).' Hello, world!';

	TestCmdLine();
//	WriteForexDataFromFile();
//	test_stock_dividend();
	phpinfo();

?>
