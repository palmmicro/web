<?php
//require_once('url.php');
require_once('debug.php');
require_once('regexp.php');
require_once('stocklink.php');
require_once('externallink.php');
//require_once('sql.php');
require_once('gb2312.php');

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
require_once('stock/etfref.php');
require_once('stock/futureetfref.php');

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

function StockGetSymbolByUrl()
{
    return StockGetSymbol(UrlGetTitle());
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
    return $sym->GetSinaFutureSymbol();
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
    $str = strstr($str, '"');
    $str = ltrim($str, '"');
    $strLeft = strstr($str, '"', true);     // works with no ending "
    if ($strLeft)   return $strLeft;
    return $str;
}

function explodeQuote($str)
{
    return explode(',', RemoveDoubleQuotationMarks($str));
}

function GetSinaQuotesUrl($strSinaSymbols)
{
	return 'http://hq.sinajs.cn/list='.$strSinaSymbols;
}	

function GetSinaQuotes($strSinaSymbols)
{ 
    $strUrl = GetSinaQuotesUrl($strSinaSymbols);
    $str = url_get_contents($strUrl);
//    DebugString('Sina:'.$strSymbols);
    if (strlen($str) < 10)      return false;   // Sina returns error in an empty file
    return $str;
}

/*
http://quote.eastmoney.com/forex/USDCNY.html
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0
*/
define('EASTMONEY_QUOTES_URL', 'http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=');
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

define('MIN_FLOAT_VAL', 0.0000001);

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
    if (empty($fPrice2))		return '';
    
    $fPercentage = StockGetPercentage($fPrice, $fPrice2);
    return strval($fPercentage).'%';
}

function StockGetPercentageDisplay($fPrice, $fPrice2)
{
    if (empty($fPrice2) || empty($fPrice))	return '';

    $fPercentage = StockGetPercentage($fPrice, $fPrice2);
    if ($fPercentage > MIN_FLOAT_VAL)    $strColor = 'black';
    else                                   $strColor = 'red';
    
    $str = strval($fPercentage);
    return "<font color=$strColor>$str%</font>";
}

function StockGetEstErrorPercentage($fEstValue, $fNetValue)
{
    if (abs($fEstValue - $fNetValue) < 0.0005)
    {
        return 0.0;
    }
	return StockGetPercentage($fEstValue, $fNetValue);
}

function StockCompareEstResult($strSymbol, $strNetValue, $strEstValue)
{
    $fPercentage = StockGetEstErrorPercentage(floatval($strEstValue), floatval($strNetValue));
    if (abs($fPercentage) > 1.0)
    {
        $strLink = GetNetValueHistoryLink($strSymbol);
        $str = sprintf('%s%s 实际值%s 估值%s 误差:%.2f%%, 从_compareEstResult函数调用.', $strSymbol, $strLink, $strNetValue, $strEstValue, $fPercentage); 
        EmailReport($str, 'Netvalue estimation error');
    }
}

// ****************************** StockReference public functions *******************************************************
function _greyString($str)
{
    return '<font color=grey>'.$str.'</font>';
}

function _italicString($str)
{
    return '<i>'.$str.'</i>';
}

function _boldString($str)
{
    return '<b>'.$str.'</b>';
}

function _convertDescriptionDisplay($str, $strDisplay)
{
    if ($str == STOCK_PRE_MARKET || $str == STOCK_POST_MARKET)	return _greyString($strDisplay);
    if ($str == STOCK_NET_VALUE)									return _boldString($strDisplay);
    if ($str == STOCK_SINA_DATA || $str == STOCK_YAHOO_DATA)		return _italicString($strDisplay);
    return $strDisplay;
}

function RefGetDescription($ref, $bChinese = true, $bConvertDisplay = false)
{
	$str = $ref->GetDescription();
	if ($str)
	{
		$ar = array(STOCK_PRE_MARKET => '盘前交易', STOCK_POST_MARKET => '盘后交易', STOCK_NET_VALUE => '净值');
		if (array_key_exists($str, $ar))
		{
			$strDisplay = $bChinese ? $ar[$str] : $str;
			if ($bConvertDisplay)
			{
				$strDisplay = _convertDescriptionDisplay($str, $strDisplay);
			}
			return $strDisplay;
		}
	}
	else
	{
		$str = '';
		$sql = new StockSql();
		if ($stock = $sql->GetById($ref->GetStockId()))
		{
			$str = $bChinese ? $stock['cn'] : $stock['us'];
			$ref->SetDescription($str);
		}
	}
    return $str;
}

function RefSortBySymbol($arRef)
{
    $ar = array();
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetStockSymbol();
        $ar[$strSymbol] = $ref; 
    }
    ksort($ar);
    
    $arSort = array();
    foreach ($ar as $str => $ref)
    {
        $arSort[] = $ref;
    }
    return $arSort;
}

// ****************************** Stock final integration functions *******************************************************
function _getAllSymbolArray($strSymbol)
{
   	$sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        if (in_arrayLof($strSymbol))									return LofGetAllSymbolArray($strSymbol);
        else if (in_arrayLofHk($strSymbol))							return LofHkGetAllSymbolArray($strSymbol);
        else if (in_arrayGoldEtf($strSymbol))						return GoldEtfGetAllSymbolArray($strSymbol);
        else if (in_arrayGradedFund($strSymbol))						return GradedFundGetAllSymbolArray($strSymbol);
        else if ($strSymbolA = in_arrayGradedFundB($strSymbol))	return GradedFundGetAllSymbolArray($strSymbolA);
        else if ($strSymbolA = in_arrayGradedFundM($strSymbol))	return GradedFundGetAllSymbolArray($strSymbolA);
        else 															return array($strSymbol);
    }

   	$ar = array();
    if ($sym->IsSymbolA())
    {
        if ($strSymbolH = SqlGetAhPair($strSymbol))	
        {
          	$ar[] = $strSymbolH;
            if ($strSymbolAdr = SqlGetHadrPair($strSymbolH))	$ar[] = $strSymbolAdr;
        }
    }
    else if ($sym->IsSymbolH())
    {
        if ($strSymbolA = SqlGetHaPair($strSymbol))				$ar[] = $strSymbolA;
        if ($strSymbolAdr = SqlGetHadrPair($strSymbol))		$ar[] = $strSymbolAdr;
    }
    else
    {
    	if ($strSymbolH = SqlGetAdrhPair($strSymbol))
        {
           	$ar[] = $strSymbolH;
            if ($strSymbolA = SqlGetHaPair($strSymbolH))		$ar[] = $strSymbolA;
        }
    }
    $ar[] = $strSymbol;
    return $ar;
}

function StockPrefetchArrayData($ar)
{
    $arAll = array();
    foreach ($ar as $strSymbol)
    {
    	if ($strSymbol)
    	{
    		$arAll = array_merge($arAll, _getAllSymbolArray($strSymbol));
    	}
    }
    PrefetchSinaStockData(array_unique($arAll));
}

function StockPrefetchData($strSymbol)
{
    StockPrefetchArrayData(array($strSymbol));
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
	$strSymbol = $sym->GetSymbol();
    if ($sym->IsSinaFund())							    	return new FundReference($strSymbol);
    else if ($strFutureSymbol = $sym->IsSinaFuture())   	return new FutureReference($strFutureSymbol);
    else if ($sym->IsSinaForex())   							return new ForexReference($strSymbol);
	else if ($sym->IsEastMoneyForex())						return new CnyReference($strSymbol);
    return new MyStockReference($strSymbol);
}

function StockGetEtfReference($strSymbol)
{
	if (SqlGetEtfPair($strSymbol))
	{
		return new EtfReference($strSymbol);
	}
	return false;
}

function StockGetHShareReference($sym)
{
	$strSymbol = $sym->GetSymbol();
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
