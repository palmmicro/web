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
require_once('stock/stockprefetch.php');
require_once('stock/stockref.php');

require_once('stock/mysqlref.php');
require_once('stock/mystockref.php');
require_once('stock/fundref.php');
require_once('stock/lofref.php');
require_once('stock/goldfundref.php');

require_once('stock/cnyref.php');
require_once('stock/forexref.php');
require_once('stock/futureref.php');
require_once('stock/hshareref.php');
require_once('stock/etfref.php');

// ****************************** Stock symbol functions *******************************************************

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
	$str = str_replace(', ', ',', $strSymbols);
    $ar = explode(',', $str);
    return StockGetArraySymbol($ar);
}

function ForexGetEastMoneySymbol($strSymbol)
{
	switch ($strSymbol)
	{
	case 'USDCNY':       return 'usdcny0';
    case 'USCNY':        return 'uscny0';
    case 'HKCNY':        return 'hkcny0';
    case 'USDHKD':       return 'usdhkd0';
    }
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
*/
// http://www.cnblogs.com/wangxinsheng/p/4260726.html
// http://blog.sina.com.cn/s/blog_7ed3ed3d0101gphj.html
// http://hq.sinajs.cn/list=sh600151,sz000830,s_sh000001,s_sz399001,s_sz399106,s_sz399107,s_sz399108
// 期货 http://hq.sinajs.cn/rn=1318986550609&amp;list=hf_CL,hf_GC,hf_SI,hf_CAD,hf_ZSD,hf_S,hf_C,hf_W
// http://hq.sinajs.cn/rn=1318986628214&amp;list=USDCNY,USDHKD,EURCNY,GBPCNY,USDJPY,EURUSD,GBPUSD,
// http://hq.sinajs.cn/list=gb_dji

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
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=USDCNY0,JPYCNY0,jpcny0,USDEUR0
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/index.aspx?type=z&ids=GLNC0,SLNC0 美黄金白银
http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/index.aspx?type=z&ids=CONM0,HONJ0,GLNM0,SLNV0,CRCN0,SBCN0,WHCN0,CRCK0,SMCN0,SOCN0,CTNN0,LCPS0,LALS0,LZNS0,LTNS0,LNKS0,LLDS0
http://hq2gjqh.eastmoney.com/em_futures2010numericapplication/index.aspx?type=f&id=CONC0
http://hq2gnqh.eastmoney.com/EM_Futures2010NumericApplication/index.aspx?type=z&ids=AUM1 沪主力金
http://hq2gjgp.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?type=f&id=SPX7
//美元指数
var AjaxDataMYZSUrl = 'http://hq2gjqh.eastmoney.com/em_futures2010numericapplication/index.aspx?type=f&jsName=DataMYZS&id=DINI0';
//汇率
var AjaxDataWHHLUrl = 'http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&jsName=DataWHHL&ids=USDCNY0,JPYCNY0,jpcny0,USDEUR0';
//道琼斯
var AjaxDataDQSUrl = 'http://hq2gjgp.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?jsName=DataDQS&reference=rtj&type=f&id=INDU7';
//纳斯达克
var AjaxDataNSDKUrl = 'http://hq2gjgp.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?jsName=DataNSDK&reference=rtj&type=f&id=CCMP7';
//标准500
var AjaxDataBZ500Url = 'http://hq2gjgp.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?jsName=DataBZ500&reference=rtj&type=f&id=SPX7';
//港股
var AjaxDataGGUrl = 'http://hq2hk.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?reference=rtj&type=z&jsName=DataGG&ids=1100005,1100105,1100305';
//原油
var AjaxDataYYUrl = 'http://hq2gjqh.eastmoney.com/em_futures2010numericapplication/index.aspx?type=f&jsName=DataYY&id=CONC0';
//IF
var AjaxDataIFUrl = 'http://hq2gnqh.eastmoney.com/EM_Futures2010NumericApplication/index.aspx?type=s&jsName=DataIF&style=12&sortType=A&sortRule=1&page=1&pageSize=2';
//A股
var AjaxDataAGUrl = 'http://hqdigi2.eastmoney.com/EM_Quote2010NumericApplication/Index.aspx?type=z&sortType=C&sortRule=-1&jsSort=1&jsName=DataAG&ids=0000011,3990012,0003001,3990052,3990062';
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

function StockGetPriceDisplay($strDisp, $strPrev, $iPrecision = false)
{
    if ($strDisp)
    {
    	$fDisp = floatval($strDisp);
    	$fPrev = floatval($strPrev);
        
        if ($fDisp > $fPrev + MIN_FLOAT_VAL)         $strColor = 'red';
        else if ($fDisp < $fPrev - MIN_FLOAT_VAL)   $strColor = 'green';
        else                                         $strColor = 'black';

        $strDisp = strval_round($fDisp, $iPrecision);
        return "<font color=$strColor>$strDisp</font>";
    }
    return '';
}

function GetNumberDisplay($fVal)
{
    return StockGetPriceDisplay(strval($fVal), '0');
}

function GetRatioDisplay($fVal)
{
    return StockGetPriceDisplay(strval($fVal), '1');
}

function StockGetPercentage($strDivisor, $strDividend)
{
	if (empty($strDivisor) || empty($strDividend))	return false;
    return (floatval($strDividend)/floatval($strDivisor) - 1.0) * 100.0;
}

function StockCompareEstResult($nv_sql, $strNetValue, $strDate, $strSymbol)
{
    if ($nv_sql->Insert($strDate, $strNetValue))
    {
       	$fund_sql = new FundEstSql($nv_sql->GetKeyId());
       	if ($strEstValue = $fund_sql->GetClose($strDate))
       	{
       		$fPercentage = StockGetPercentage($strNetValue, $strEstValue);
       		if (($fPercentage !== false) && (abs($fPercentage) > 1.0))
       		{
       			$strLink = GetNetValueHistoryLink($strSymbol);
       			$str = sprintf('%s%s 实际值%s 估值%s 误差:%.2f%%', $strSymbol, $strLink, $strNetValue, $strEstValue, $fPercentage); 
       			trigger_error('Net value estimation error '.$str);
       		}
       	}
    	return true;
    }
    return false;
}

function StockUpdateEstResult($nv_sql, $fund_sql, $strNetValue, $strDate)
{
	if ($nv_sql->Get($strDate) == false)
    {   // Only update when net value is NOT ready
		$fund_sql->Write($strDate, $strNetValue);
	}
}

// ****************************** StockReference public functions *******************************************************
function _grayString($str)
{
    return '<font color=gray>'.$str.'</font>';
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
    if ($str == STOCK_PRE_MARKET || $str == STOCK_POST_MARKET)	return _grayString($strDisplay);
    if ($str == STOCK_NET_VALUE)									return _boldString($strDisplay);
    if ($str == STOCK_SINA_DATA || $str == STOCK_YAHOO_DATA)		return _italicString($strDisplay);
    return $strDisplay;
}

function RefGetDescription($ref, $bConvertDisplay = false)
{
	$str = $ref->GetDescription();
	if ($str)
	{
		$ar = array(STOCK_PRE_MARKET => '盘前交易', STOCK_POST_MARKET => '盘后交易', STOCK_NET_VALUE => STOCK_DISP_NETVALUE);
		if (array_key_exists($str, $ar))
		{
			$strDisplay = $ar[$str];
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
		if ($record = $sql->GetById($ref->GetStockId()))
		{
			$str = $record['name'];
			$ref->SetDescription($str);
		}
	}
    return $str;
}

function RefGetStockDisplay($ref)
{
    return RefGetDescription($ref).'【'.$ref->GetStockSymbol().'】';
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
function EtfGetAllSymbolArray($strSymbol)
{
    return array($strSymbol, SqlGetEtfPair($strSymbol));
}

function _getAllSymbolArray($strSymbol)
{
   	$sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        if (in_arrayLof($strSymbol))									return LofGetAllSymbolArray($strSymbol);
        else if (in_arrayLofHk($strSymbol))							return LofHkGetAllSymbolArray($strSymbol);
        else if (in_arrayGoldEtf($strSymbol))						return GoldEtfGetAllSymbolArray($strSymbol);
        else if (in_arrayChinaEtf($strSymbol))						return EtfGetAllSymbolArray($strSymbol);
        else 															return array($strSymbol);
    }
    
   	$ar = array();
    if ($strPairSymbol = SqlGetEtfPair($strSymbol))			$ar[] = $strPairSymbol;
    if ($sym->IsSymbolA())
    {
    	$ab_sql = new AbPairSql();
    	if ($strSymbolB = $ab_sql->GetPairSymbol($strSymbol))		$ar[] = $strSymbolB;
    	else if ($strSymbolA = $ab_sql->GetSymbol($strSymbol))	$ar[] = $strSymbolA;
    		
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

function StockPrefetchData()
{
    StockPrefetchArrayData(func_get_args());
}

function StockGetFundReference($strSymbol)
{
    if (in_arrayLof($strSymbol))                 $ref = new LofReference($strSymbol);
    else if (in_arrayLofHk($strSymbol))         $ref = new LofHkReference($strSymbol);
    else if (in_arrayGoldEtf($strSymbol))       $ref = new GoldFundReference($strSymbol);
//    else if (in_arrayChinaEtf($strSymbol))       $ref = new EtfReference($strSymbol);
    else
    {
        $ref = new FundReference($strSymbol);
    }
    return $ref;
}

function StockGetReference($strSymbol, $sym = false)
{
	if ($sym == false)	$sym = new StockSymbol($strSymbol);

    if ($sym->IsSinaFund())				return new FundReference($strSymbol);
    else if ($sym->IsSinaFuture())   		return new FutureReference($strSymbol);
    else if ($sym->IsSinaForex())   		return new ForexReference($strSymbol);
	else if ($sym->IsEastMoneyForex())	return new CnyReference($strSymbol);
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
