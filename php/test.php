<?php
require_once('debug.php');
//require_once('email.php');
//require_once('account.php');
require_once('stock.php');
require_once('stock/ftstock.php');
require_once('stock/marketwatch.php');

//require_once('ahstockarray.php');
require_once('sql/_sqltest.php');
//require_once('gb2312/gb2312_tools.php');
//require_once('test/chinastocklist.php');

require_once('csvfile.php');
require_once('test/XOP_HistoricalNav.php');

// http://www.todayir.com/en/index.php HSFML25
/*
function TestGoogleHistory()
{
//    $strSymbol = 'NASDAQ:ADBE';
//    $strSymbol = '^SPSIOP';
//    $strSymbol = '^GSPC';
    $strSymbol = 'XOP';
    $sym = new StockSymbol($strSymbol);
    $str = StockGetGoogleHistoryQuotes($sym->GetGoogleSymbol(), 'Jan+01%2C+2009', 'Aug+2%2C+2012');
    $strFileName = DebugGetGoogleHistoryFileName($strSymbol);
    file_put_contents($strFileName, $str);
    $strLink = GetFileDebugLink($strFileName);
    DebugString($strLink);
}
*/

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
	SqlCreateParameterTable(TABLE_DIVIDEND_PARAMETER);
    foreach ($arSymbolData as $strSymbol => $arData)
    {
        SqlUpdateStockChineseDescription($strSymbol, $arData['name']);
        
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
//            DebugString($strSymbol.' '.$arData['trade'].' '.$arData['per'].' '.strval(round($fDividendRate, 4)));
            $arOutput[$strSymbol] = $fDividendRate; 
        }
    }
    
    arsort($arOutput);
    DebugString('总数: '.strval(count($arOutput)));
    DebugString('代码 名称 当前交易价格 价格涨跌百分比 交易时间 PB PE 骑姐分红指标');
    foreach ($arOutput as $strSymbol => $fDividendRate)
    {
        $arData = $arSymbolData[$strSymbol];
        DebugString($strSymbol.' '.$arData['name'].' '.$arData['trade'].' '.$arData['changepercent'].' '.$arData['ticktime'].' '.$arData['pb'].' '.$arData['per'].' '.strval(round($fDividendRate, 4)));
    }
}

function SysInit()
{
	if (SqlConnectDatabase())
	{
	    DebugString('connect database ok');
	}
	
//	GB2312WriteDatabase();
//	AhWriteDatabase();		
//	AdrhWriteDatabase();
}

function TestCmdLine()
{
	DebugString('cmd line test '.UrlGetQueryString());
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$strSrc = UrlGetQueryDisplay('src', 'yahoo');
    	$ref = new MyStockReference($strSymbol);
    	DebugString(SqlGetStockId($strSymbol));
    	$fStart = microtime(true);
    	if ($strSrc == 'yahoo')		
    	{
    		$str = TestYahooWebData($strSymbol);
    		YahooUpdateNetValue($strSymbol);
    	}
    	else if ($strSrc == 'ft')	$str = TestFtStock($strSymbol);
    	else if ($strSrc == 'sina')
    	{
//    		_debug_dividend($strSymbol);
			$str = TestSinaStockHistory($strSymbol);
    	}
    	else if ($strSrc == 'nav')
    	{
//    		$str = SaveHistoricalNav($strSymbol);
    	}
    	$fStop = microtime(true);
    	if (empty($str))	$str = '(Not found)';
    	DebugString($strSymbol.':'.$str.DebugGetStopWatchDisplay($fStop, $fStart));
    }
}

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    DebugClear();
	DebugString($_SERVER['DOCUMENT_ROOT']);
	DebugString(phpversion());
	SysInit();
	echo 'Hello, world! '.strval(rand());

	TestCmdLine();
//	WriteForexDataFromFile();
//	MarketWatchGetData('^SPSIOP');
//	test_stock_dividend();
//	SqlDeleteStockGroupByGroupName('SINA');
//  TestGoogleHistory();
	phpinfo();

?>
