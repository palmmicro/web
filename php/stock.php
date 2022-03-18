<?php
require_once('regexp.php');
require_once('stocklink.php');
require_once('externallink.php');
require_once('sql.php');
require_once('gb2312.php');

require_once('sql/sqlipaddress.php');
require_once('sql/sqlstock.php');

require_once('stock/stocksymbol.php');
require_once('stock/yahoostock.php');
require_once('stock/stockprefetch.php');
require_once('stock/stockref.php');

require_once('stock/mysqlref.php');
require_once('stock/mystockref.php');
require_once('stock/cnyref.php');
require_once('stock/netvalueref.php');
require_once('stock/holdingsref.php');
require_once('stock/futureref.php');
require_once('stock/fundref.php');
require_once('stock/qdiiref.php');
require_once('stock/goldfundref.php');

require_once('stock/forexref.php');
require_once('stock/hshareref.php');
require_once('stock/etfref.php');

// ****************************** Stock symbol functions *******************************************************

function GetYahooNetValueSymbol($strEtfSymbol)
{
    if (empty($strEtfSymbol))   return false;
    return YAHOO_INDEX_CHAR.$strEtfSymbol.'-IV';
}

// ****************************** Stock data functions *******************************************************

/* Sina data
nf_IC2006
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

function StockNeedFile($strFileName, $iInterval = SECONDS_IN_MIN)
{
   	clearstatcache(true, $strFileName);
   	if (file_exists($strFileName))
   	{
   		$now_ymd = GetNowYMD();
   		return $now_ymd->NeedFile($strFileName, $iInterval);
   	}
   	return true;
}

define('SINA_QUOTES_SEPARATOR', ',');
function GetSinaQuotes($strSinaSymbols)
{
	$strFileName = DebugGetPathName('debugsina.txt');
	$iCount = count(explode(SINA_QUOTES_SEPARATOR, $strSinaSymbols));
	if (DebugIsAdmin() && $iCount > 1)	DebugVal('total prefetch - '.$strSinaSymbols, $iCount);
	else
	{
		if (StockNeedFile($strFileName) == false)
		{	// pause 1 minute after curl error response
			DebugString('Ignored: '.$strSinaSymbols, true);
			return false;
		}
	}
    
    if ($str = url_get_contents(GetSinaQuotesUrl($strSinaSymbols), false, 'http://stock.finance.sina.com.cn/usstock/quotes/SPY.html', $strFileName))
    {
    	if ($iCount >= count(explode('=', $str)))		DebugVal('GetSinaQuotes failed', $iCount);		// Sina returns error in an empty file
    	else												return $str;
    }
    return false;
}

// ****************************** Stock display functions *******************************************************

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
        return GetFontElement($strDisp, $strColor);
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
	$f = floatval($strDivisor);
	if ($f == 0.0)
	{
		return false;
	}
    return (floatval($strDividend)/$f - 1.0) * 100.0;
}

function StockCompareEstResult($fund_est_sql, $strStockId, $strNetValue, $strDate, $strSymbol)
{
	$nav_sql = GetNavHistorySql();
    if ($nav_sql->InsertDaily($strStockId, $strDate, $strNetValue))
    {
       	if ($strEstValue = $fund_est_sql->GetClose($strStockId, $strDate))
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

function StockUpdateEstResult($fund_est_sql, $strStockId, $strNetValue, $strDate)
{
	$nav_sql = GetNavHistorySql();
	if ($nav_sql->GetRecord($strStockId, $strDate) == false)
    {   // Only update when net value is NOT ready
		$fund_est_sql->WriteDaily($strStockId, $strDate, $strNetValue);
	}
}

// ****************************** StockReference public functions *******************************************************
function SymGetStockName($sym)
{
	$sql = GetStockSql();
	return $sql->GetStockName($sym->GetSymbol());
}

function RefGetTableColumnNav($ref)
{
	$strStockDisplay = GetTableColumnStock($ref);
	if ($ref->CountNav() > 0)		return new TableColumnNav($strStockDisplay);	
	return 								new TableColumnPrice($strStockDisplay);
}

function FundGetPosition($ref)
{
	$sql = new FundPositionSql();
   	if ($fRatio = $sql->ReadVal($ref->GetStockId()))	return $fRatio;
	return $ref->GetDefaultPosition();  
}

// ****************************** Stock final integration functions *******************************************************
function StockPrefetchArrayData($arSymbol)
{
    PrefetchSinaStockData(array_unique($arSymbol));
}

function EtfGetAllSymbolArray($strSymbol)
{
    return array($strSymbol, SqlGetEtfPair($strSymbol));
}

function _getAllSymbolArray($strSymbol, $strStockId)
{
   	$sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        if (in_arrayQdiiMix($strSymbol))						       	return array_merge(array($strSymbol), SqlGetHoldingsSymbolArray($strSymbol));
        else if (in_arrayQdii($strSymbol))		        			return QdiiGetAllSymbolArray($strSymbol);
        else if (in_arrayQdiiHk($strSymbol))							return QdiiHkGetAllSymbolArray($strSymbol);
        else if (in_arrayChinaIndex($strSymbol))						return EtfGetAllSymbolArray($strSymbol);
        else if (in_arrayGoldSilver($strSymbol))						return GoldSilverGetAllSymbolArray($strSymbol);
        else 															return array($strSymbol);
    }
    
	$ar = SqlGetHoldingsSymbolArray($strSymbol);
	if ($ar == false)		$ar = array();
	
    if ($strPairSymbol = SqlGetEtfPair($strSymbol))			   	$ar[] = $strPairSymbol;
    
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

function StockPrefetchArrayExtendedData($ar)
{
    $arAll = array();
    
	$sql = GetStockSql();
    foreach ($ar as $strSymbol)
    {
   		if ($strStockId = $sql->GetId($strSymbol))		$arAll = array_merge($arAll, _getAllSymbolArray($strSymbol, $strStockId));
   		else								    			$arAll[] = $strSymbol;	// new stock symbol	
    }
    StockPrefetchArrayData($arAll);
}

function StockPrefetchExtendedData()
{
    StockPrefetchArrayExtendedData(func_get_args());
}

function StockGetFundReference($strSymbol)
{
    if (in_arrayQdii($strSymbol))                 $ref = new QdiiReference($strSymbol);
    else if (in_arrayQdiiHk($strSymbol))         $ref = new QdiiHkReference($strSymbol);
    else if (in_arrayGoldSilver($strSymbol))       $ref = new GoldFundReference($strSymbol);
//    else if (in_arrayChinaIndex($strSymbol))       $ref = new EtfReference($strSymbol);
    else
    {
        $ref = new FundReference($strSymbol);
    }
    return $ref;
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

function UseSameDayNav($sym)
{
	$strSymbol = $sym->GetSymbol();
	if (in_arrayQdii($strSymbol) || in_arrayQdiiMix($strSymbol))
	{
		return false;
	}
	return true;
}

	
?>
