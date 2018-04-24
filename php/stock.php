<?php
//require_once('url.php');
require_once('debug.php');
require_once('regexp.php');
require_once('stocklink.php');
require_once('externallink.php');
//require_once('sql.php');
require_once('gb2312.php');

require_once('class/year_month_date.php');

require_once('sql/sqlstock.php');

require_once('stock/stocksymbol.php');
require_once('stock/chinamoney.php');
require_once('stock/yahoostock.php');
require_once('stock/sinastock.php');
require_once('stock/googlestock.php');
require_once('stock/stockprefetch.php');
require_once('stock/stockref.php');

require_once('stock/mysqlref.php');
require_once('stock/mystockref.php');
require_once('stock/fundref.php');
require_once('stock/lofref.php');
require_once('stock/goldfundref.php');
require_once('stock/gradedfundref.php');

require_once('stock/cnyref.php');
require_once('stock/forexref.php');
require_once('stock/futureref.php');
require_once('stock/hshareref.php');

//require_once('stocktrans.php');
//require_once('stockgroup.php');

// ****************************** Stock symbol functions *******************************************************

function StockBuildChineseSymbol($strDigit)
{
    if (intval($strDigit) < 500000)
    {
        return SHENZHEN_PREFIX.$strDigit;
    }
    return SHANGHAI_PREFIX.$strDigit;
}            

function StockGetSymbol($str)
{
    return strtoupper(trim($str));
}

function StockGetArraySymbol($ar)
{
    $arSymbol = array();
    foreach ($ar as $str)
    {
        $arSymbol[] = StockGetSymbol($str); 
    }
    return $arSymbol;
}

function StockGetSymbolArray($strSymbols)
{
    $ar = explode(',', $strSymbols);
    return StockGetArraySymbol($ar);
}

function FutureGetSinaSymbol($strSymbol)
{
    if ($strSymbol == false)    return false;
    
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFutureCn())
    {   // AU0
        return $strSymbol;
    }
    return SINA_FUTURE_PREFIX.$strSymbol;
}

function ForexGetEastMoneySymbol($strSymbol)
{
    if ($strSymbol == 'USDCNY')             return 'usdcny0';
    else if ($strSymbol == 'USCNY')        return 'uscny0';
    else if ($strSymbol == 'HKCNY')        return 'hkcny0';
    else if ($strSymbol == 'USDHKD')       return 'usdhkd0';
    return false;
}
/*
function _HasSinaRealtimeHkData($strSymbol)
{
    return true;
}
*/

function GetYahooNetValueSymbol($strEtfSymbol)
{
    if (empty($strEtfSymbol))   return false;
    return YAHOO_INDEX_CHAR.$strEtfSymbol.'-IV';
}

// ****************************** Stock data functions *******************************************************

/* Sina data
http://hq.sinajs.cn/list=s_sh000001 上证指数
http://hq.sinajs.cn/list=s_sz399001 深证成指
http://hq.sinajs.cn/list=int_hangseng 恒生指数
http://hq.sinajs.cn/list=s_sz399300 沪生300
http://hq.sinajs.cn/list=int_dji 道琼斯
http://hq.sinajs.cn/list=int_nasdaq 纳斯达克
http://hq.sinajs.cn/list=int_sp500 标普500
http://hq.sinajs.cn/list=int_ftse 英金融时报指数
http://hq.sinajs.cn/list=gb_xop
http://stock.finance.sina.com.cn/usstock/quotes/XOP.html
*/
// http://www.cnblogs.com/wangxinsheng/p/4260726.html
// http://blog.sina.com.cn/s/blog_7ed3ed3d0101gphj.html
// http://hq.sinajs.cn/list=sh600151,sz000830,s_sh000001,s_sz399001,s_sz399106,s_sz399107,s_sz399108
// 期货 http://hq.sinajs.cn/rn=1318986550609&amp;list=hf_CL,hf_GC,hf_SI,hf_CAD,hf_ZSD,hf_S,hf_C,hf_W
// http://hq.sinajs.cn/rn=1318986628214&amp;list=USDCNY,USDHKD,EURCNY,GBPCNY,USDJPY,EURUSD,GBPUSD,
// http://hq.sinajs.cn/list=gb_dji
// http://hq.sinajs.cn/list=hk02828

function RemoveDoubleQuotationMarks($str)
{
    $str = strchr($str, '"');
    $str = ltrim($str, '"');
    $strLeft = strchr($str, '"', true);     // works with no ending "
    if ($strLeft)   return $strLeft;
    return $str;
}

function explodeQuote($str)
{
    return explode(',', RemoveDoubleQuotationMarks($str));
}

define ('SINA_QUOTES_URL', 'http://hq.sinajs.cn/list=');
function GetSinaQuotes($strSymbols)
{ 
    $strUrl = SINA_QUOTES_URL.$strSymbols;
    $str = url_get_contents($strUrl);
//    DebugString('Sina:'.$strSymbols);
    if (strlen($str) < 10)      return false;   // Sina returns error in an empty file
    return $str;
}

/*
$stockCode = 600000
$url = "http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/{0}.phtml" -f $stockCode
$wc = New-Object System.Net.WebClient
$content = $wc.DownloadString($url)

$reg = "<a target='_blank's+href='http://biz.finance.sina.com.cn/stock/history_min.php?symbol=shd{6}&date=d{4}-d{2}-d{2}'>s*([^s]+)s+</a>s*</div></td>s*<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+<td[^d]*([^<]*)</div></td>s+"
$result = [RegEx]::matches($content, $reg)

foreach($item in $result)
{
    $date = $item.Groups[1].Value # 时间
    $opening = $item.Groups[2].Value # 开盘
    $maxHigh = $item.Groups[3].Value # 最高
    $closing = $item.Groups[4].Value # 收盘
    $maxLow = $item.Groups[5].Value # 最低
    Write-Host $date $opening $maxHigh $closing $maxLow
}

http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/601006.phtml
*/

/*
http://quote.eastmoney.com/forex/USDCNY.html
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0
*/
define ('EASTMONEY_QUOTES_URL', 'http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=');
function GetEastMoneyQuotes($strSymbols)
{ 
    $strUrl = EASTMONEY_QUOTES_URL.$strSymbols;
    $str = url_get_contents($strUrl);
//    DebugString('EastMoney:'.$strSymbols);
    if (strlen($str) < 10)      return false;   // Check if it is an empty file
    return $str;
}

// ****************************** Stock display functions *******************************************************

function ForexAndFutureGetTimezone()
{
    return 'GMT';
}

define ('MIN_FLOAT_VAL', 0.0000001);

function FloatNotZero($fVal)
{
    if (abs($fVal) > MIN_FLOAT_VAL)     return true;
    return false;
}

function round_display($fCur)
{
    if (abs($fCur) > (10 - MIN_FLOAT_VAL))        $fCur = round($fCur, 2);
    else if (abs($fCur) > (2 - MIN_FLOAT_VAL))   $fCur = round($fCur, 3);
    else                                            $fCur = round($fCur, 4);
    return strval($fCur);
}

function round_display_str($str)
{
    return round_display(floatval($str));
}

function StockGetPriceDisplay($fCur, $fPre)
{
    if ($fCur)
    {
        $strCur = round_display($fCur);
        
        if ($fCur > $fPre + MIN_FLOAT_VAL)         $strColor = 'red';
        else if ($fCur < $fPre - MIN_FLOAT_VAL)   $strColor = 'green';
        else                                         $strColor = 'black';

        return "<font color=$strColor>$strCur</font>";
    }
    return '';
}

function GetNumberDisplay($fVal)
{
    return StockGetPriceDisplay($fVal, 0.0);
}

function GetRatioDisplay($fVal)
{
    return StockGetPriceDisplay($fVal, 1.0);
}

function StockGetPercentage($fPrice, $fPrice2)
{
    $fPercentage = ($fPrice/$fPrice2 - 1.0) * 100.0;
    return round($fPercentage, 2);
}

function StockGetPercentageText($fPrice, $fPrice2)
{
    if (FloatNotZero($fPrice2))
    {
        $fPercentage = StockGetPercentage($fPrice, $fPrice2);
        return strval($fPercentage).'%';
    }
    return '';
}

function StockGetPercentageDisplay($fPrice, $fPrice2)
{
    if ($fPrice2 && FloatNotZero($fPrice2) && FloatNotZero($fPrice))
    {
        $fPercentage = StockGetPercentage($fPrice, $fPrice2);
        if ($fPercentage > MIN_FLOAT_VAL)    $strColor = 'black';
        else                                   $strColor = 'red';
    
        $str = strval($fPercentage);
        return "<font color=$strColor>$str%</font>";
    }
    return '';
}

// ****************************** Stock final integration functions *******************************************************

function _prefetchStockData($arStockSymbol)
{
    $arUnknown = PrefetchSinaStockData($arStockSymbol);
    $arUnknown = PrefetchGoogleStockData($arUnknown);
    PrefetchYahooData($arUnknown);
}

function StockPrefetchData($ar)
{
    $arAll = array();
    foreach ($ar as $strSymbol)
    {
    	$sym = new StockSymbol($strSymbol);
        if ($sym->IsFundA())
        {
            if (in_arrayLof($strSymbol))                $arAll = array_merge($arAll, LofGetAllSymbolArray($strSymbol));
            else if (in_arrayLofHk($strSymbol))         $arAll = array_merge($arAll, LofHkGetAllSymbolArray($strSymbol));
            else if (in_arrayGoldEtf($strSymbol))       $arAll = array_merge($arAll, GoldEtfGetAllSymbolArray($strSymbol));
            else if (in_arrayGradedFund($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbol));
            else if ($strSymbolA = in_arrayGradedFundB($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbolA));
            else if ($strSymbolA = in_arrayGradedFundM($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbolA));
        }
        else
        {
            if ($sym->IsSymbolA())
            {
                if ($strSymbolH = SqlGetAhPair($strSymbol))	
                {
                	$arAll[] = $strSymbolH;
                	if ($strSymbolAdr = SqlGetHadrPair($strSymbolH))	$arAll[] = $strSymbolAdr;
                }
            }
            else if ($sym->IsSymbolH())
            {
                if ($strSymbolA = SqlGetHaPair($strSymbol))			$arAll[] = $strSymbolA;
                if ($strSymbolAdr = SqlGetHadrPair($strSymbol))	$arAll[] = $strSymbolAdr;
            }
            else
            {
            	if ($strSymbolH = SqlGetAdrhPair($strSymbol))
            	{
                	$arAll[] = $strSymbolH;
                	if ($strSymbolA = SqlGetHaPair($strSymbolH))	$arAll[] = $strSymbolA;
                }
            }
            $arAll[] = $strSymbol;
        }
    }
    _prefetchStockData(array_unique($arAll));
}

function StockGetFundReference($strSymbol)
{
    if (in_arrayLof($strSymbol))                 $ref = new LofReference($strSymbol);
    else if (in_arrayLofHk($strSymbol))         $ref = new LofHkReference($strSymbol);
    else if (in_arrayGoldEtf($strSymbol))       $ref = new GoldFundReference($strSymbol);
    else if (in_arrayGradedFund($strSymbol))    $ref = new GradedFundReference($strSymbol);
    else if ($strSymbolA = in_arrayGradedFundB($strSymbol))
    {
        $a_ref = new GradedFundReference($strSymbolA);
        $ref = $a_ref->b_ref;
    }
    else if ($strSymbolA = in_arrayGradedFundM($strSymbol))
    {
        $a_ref = new GradedFundReference($strSymbolA);
        $ref = $a_ref->m_ref;
    }
    else
    {
        $ref = new FundReference($strSymbol);
    }
    return $ref;
}

function StockGetReference($sym)
{
	$strSymbol = $sym->strSymbol;
    if ($sym->IsSinaFund())							    	return new FundReference($strSymbol);
    else if ($strFutureSymbol = $sym->IsSinaFuture())   	return new FutureReference($strFutureSymbol);
    else if ($sym->IsSinaForex())   							return new ForexReference($strSymbol);
	else if ($sym->IsEastMoneyForex())						return new CnyReference($strSymbol);
    return new MyStockReference($strSymbol);
}

function StockGetHShareReference($sym)
{
	$strSymbol = $sym->strSymbol;
   	if ($sym->IsSymbolA())
   	{
    	if ($strSymbolH = SqlGetAhPair($strSymbol))
    	{
        	$hshare_ref = new HShareReference($strSymbolH);
   			return array($hshare_ref->a_ref, $hshare_ref);
      	}
    }
    else if ($sym->IsSymbolH())
    {
       	$hshare_ref = new HShareReference($strSymbol);
		return array($hshare_ref, $hshare_ref);
    }
   	else 	// if ($sym->IsSymbolUS())
   	{
    	if ($strSymbolH = SqlGetAdrhPair($strSymbol))
    	{
        	$hshare_ref = new HShareReference($strSymbolH);
   			return array($hshare_ref->adr_ref, $hshare_ref);
      	}
    }
    return false;
}

?>
