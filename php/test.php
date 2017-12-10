<?php
require_once('debug.php');
require_once('url.php');
//require_once('email.php');
require_once('regexp.php');
require_once('gb2312.php');

require_once('sqlquery.php');
require_once('sql/sqlstocksymbol.php');
//require_once('sql/sqlstockgroup.php');
require_once('sql/sqlstockhistory.php');
require_once('sql/sqlparameter.php');

require_once('stock/stocksymbol.php');
require_once('stock/sinastock.php');
require_once('stock/googlestock.php');
require_once('stock/yahoostock.php');
require_once('stock/stockprefetch.php');

//require_once('account.php');
//require_once('stock.php');
//require_once('sql/_sqltest.php');

//require_once('test/chinastocklist.php');


function echoDebugString($str)
{
    echo $str.'<br />';
	DebugString($str);
}

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
    $strLink = DebugGetFileLink($strFileName);
    echoDebugString($strLink);
}
*/

/*
<a target='_blank' href='http://vip.stock.finance.sina.com.cn/quotes_service/view/vMS_tradehistory.php?symbol=sh601006&date=2017-06-02'>
			2017-06-02			</a>
						</div></td>
			<td><div align="center">8.400</div></td>
			<td><div align="center">8.470</div></td>
			<td><div align="center">8.420</div></td>
			<td class="tdr"><div align="center">8.370</div></td>
			<td class="tdr"><div align="center">17822614</div></td>
			<td class="tdr"><div align="center">150050580</div></td>
*/			
			
function test_preg_match()
{
//    $strPattern = "<a target='_blank's+href='http://biz.finance.sina.com.cn/stock/history_min.php?symbol=shd{6}&date=d{4}-d{2}-d{2}'>s*([^s]+)s+</a>s*</div></td>s*<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+";
//    $strPattern = '/symbol=sh\d{6}&date=\d{4}-\d{2}-\d{2}''>\s+\d{4}-\d{2}-\d{2}\s+</';
    $strBoundary = RegExpBoundary();
    $strSpace = RegExpSpace();
    
    $strPattern = $strBoundary;
    $strPattern .= 'http://vip.stock.finance.sina.com.cn/quotes_service/view/vMS_tradehistory.php';
    $strPattern .= '\?';
    $strPattern .= 'symbol=sh\d{6}&date=\d{4}-\d{2}-\d{2}';
    $strPattern .= "'";
    $strPattern .= RegExpParenthesis('>'.$strSpace, '\S*', $strSpace.'</a>'.$strSpace.'</div></td>'.$strSpace);
    for ($i = 0; $i < 6; $i ++) $strPattern .= RegExpParenthesis('<td[^\d]*', '[^<]*', '</div></td>'.$strSpace);
    $strPattern .= $strBoundary;
    $strSubject = url_get_contents('http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/601006.phtml');
    $arMatch = array();
    $iVal = preg_match_all($strPattern, $strSubject, $arMatch, PREG_SET_ORDER);
    DebugVal($iVal);
    for ($j = 0; $j < $iVal; $j ++)
    {
        DebugString($arMatch[$j][0]);
        for ($i = 1; $i < 8; $i ++) echoDebugString($arMatch[$j][$i]);
    }
    return $iVal;
}

function _debug_dividend($strSymbol)
{
	$arMatch = SinaGetStockDividendA($strSymbol);
	$iVal = count($arMatch);
	
    DebugVal($iVal);
    for ($j = 0; $j < $iVal; $j ++)
    {
        DebugString($arMatch[$j][0]);
        for ($i = 1; $i < 9; $i ++) echoDebugString($arMatch[$j][$i]);
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
	SqlCreateStockTable();
	SqlCreateParameterTable(DIVIDEND_PARAMETER_TABLE);
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
//            echoDebugString($strSymbol.' '.$arData['trade'].' '.$arData['per'].' '.strval(round($fDividendRate, 4)));
            $arOutput[$strSymbol] = $fDividendRate; 
        }
    }
    
    arsort($arOutput);
    echoDebugString('总数: '.strval(count($arOutput)));
    echoDebugString('代码 名称 当前交易价格 价格涨跌百分比 交易时间 PB PE 骑姐分红指标');
    foreach ($arOutput as $strSymbol => $fDividendRate)
    {
        $arData = $arSymbolData[$strSymbol];
        echoDebugString($strSymbol.' '.$arData['name'].' '.$arData['trade'].' '.$arData['changepercent'].' '.$arData['ticktime'].' '.$arData['pb'].' '.$arData['per'].' '.strval(round($fDividendRate, 4)));
    }
}

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    
//	phpinfo();
    DebugClear();
    echoDebugString('Admin test debug begin ...');
	echoDebugString($_SERVER['DOCUMENT_ROOT']);
	echoDebugString(phpversion());
	if (SqlConnectDatabase())
	{
	    echoDebugString('connect database ok');
	}

//	_debug_dividend('sz000028');
//	test_stock_dividend();
//	SqlDeleteStockGroupByGroupName('YZC');
//	SqlUpdateStockHistoryAdjCloseByDividend('1293', 0.50);
//	echoDebugString(url_get_contents('http://palmmicro.com/php/spidercn.php?list=sz162411'));
//    TestGoogleHistory();

/*
    if (test_preg_match() > 1)    echoDebugString('matched');
	else                            echoDebugString('NOT matched');
*/
	
    echoDebugString('Admin test done.');

?>
