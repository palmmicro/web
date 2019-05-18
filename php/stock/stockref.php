<?php
define('TRADING_QUOTE_NUM', 5);

define('STOCK_SINA_DATA', 'Sina Data');
define('STOCK_YAHOO_DATA', 'Yahoo Data (possible 15 min delay)');
define('STOCK_GOOGLE_DATA', 'Google Data');
define('STOCK_EASTMONEY_DATA', 'East Money Data');
define('STOCK_MYSQL_DATA', 'Data from MySQL');

define('STOCK_NET_VALUE', 'Net Value');
define('STOCK_PRE_MARKET', 'Pre-Market Trading');
define('STOCK_POST_MARKET', 'Post-Market Trading');

// ****************************** Public functions *******************************************************
// 06:56:22 => 06:56
function GetTimeHM($strHMS)
{
    return substr($strHMS, 0, 5);
}

// 11:11pm, 10:59PM
function GetHourFromStrEndWithPM($strEndWithPM)
{
    $iHour = intval(strstr($strEndWithPM, ':', true));
    if (strtolower(substr($strEndWithPM, -2, 2)) == 'pm')
    {
        if ($iHour < 12)   $iHour += 12;
    }
    return $iHour;
}

// ****************************** Protected functions *******************************************************

function _GetForexAndFutureArray($strSymbol, $strFileName, $strTimeZone, $callback)
{
    if (ForexAndFutureNeedNewFile($strFileName, $strTimeZone))
    {
        $str = call_user_func($callback, $strSymbol);
        if ($str)   file_put_contents($strFileName, $str);
        else         $str = file_get_contents($strFileName);
    }
    else
    {
        $str = file_get_contents($strFileName);
    }
    return explodeQuote($str);
}

// ****************************** Private functions *******************************************************

define('COMMA_REPLACEMENT', '*');

//  "Actions Semiconductor Co., Ltd." ==> "Actions Semiconductor Co.* Ltd."
function _replaceCommaInsideQuotationMarks($str)
{
    $strNew = '';
    $bQuotation = false;
   
    for ($i = 0; $i < strlen($str); $i ++)
    {
        $strChar = substr($str, $i, 1);
        if ($strChar == '"')
        {
            if ($bQuotation)   $bQuotation = false;
            else                 $bQuotation = true; 
        }
        else if ($strChar == ',')
        {
            if ($bQuotation)   $strChar = COMMA_REPLACEMENT;
        }
        $strNew .= $strChar;
    }
    return $strNew;
}

// "+2.3%", "-11.37%", "N/A"
function _convertYahooPercentage($strChange)
{
    $str = RemoveDoubleQuotationMarks($strChange);
    if ($str == 'N/A')     return 0.0;
    
    if (substr($str, 0, 1) == '+')   $str = ltrim($str, '+');
    return floatval(rtrim($str, '%')) / 100.0;
}

// "9:59am" "11:11pm"
function _convertYahooTime($strAmpm)
{
	if ($strAmpm == 'N/A')		return '';
    $str = RemoveDoubleQuotationMarks($strAmpm);
    $iHour = GetHourFromStrEndWithPM($str);
    $str = strstr($str, ':');
    $iMin = intval(substr($str, 1, 2));
    
    return sprintf('%02d:%02d:00', $iHour, $iMin);
}

// "1/26/2016"
function _convertYahooDate($strMdy)
{
	if ($strMdy == 'N/A')		return '';
    $str = RemoveDoubleQuotationMarks($strMdy);
    $ar = explode('/', $str);
    $strMonth = $ar[0];
    if (intval($strMonth) < 10)     $strMonth = '0'.$strMonth;
    $strDay = $ar[1];
    if (intval($strDay) < 10)     $strDay = '0'.$strDay;
    return $ar[2].'-'.$strMonth.'-'.$strDay;
}

function _getSinaArray($sym, $strSinaSymbol, $strFileName)
{
    if (StockNeedNewQuotes($sym, $strFileName))
    {
        $str = GetSinaQuotes($strSinaSymbol);
        if ($str)   file_put_contents($strFileName, $str);
        else         $str = file_get_contents($strFileName);
    }
    else
    {
        $str = file_get_contents($strFileName);
    }
    return explodeQuote($str);
}

function _getGoogleFile($strGoogleSymbol, $strFileName)
{
    $str = GetGoogleQuotes($strGoogleSymbol);
    if ($str)   file_put_contents($strFileName, $str);
    else         $str = file_get_contents($strFileName);
    return $str;
}

function _getGoogleArray($sym, $strGoogleSymbol, $strFileName)
{
    if (StockNeedNewQuotes($sym, $strFileName))
    {
        $str = _getGoogleFile($strGoogleSymbol, $strFileName);
    }
    else
    {
        $str = file_get_contents($strFileName);
        if (strlen($str) < 10)
        {
            $str = _getGoogleFile($strGoogleSymbol, $strFileName);
        }
    }
    return json_decode($str, true);
}

function _getYahooStr($sym, $strYahooSymbol, $strFileName)
{
    if (StockNeedNewQuotes($sym, $strFileName))
    {
        $str = GetYahooQuotes($strYahooSymbol);
        file_put_contents($strFileName, $str);
    }
    else
    {
        $str = file_get_contents($strFileName);
    }
    return $str;
}

// ****************************** StockReference Class *******************************************************

class StockReference
{
    var $sym = false;                  // StockSymbol class
    var $strDescription = false;     // Stock description
    
    var $strFileName;                       // File to store original data
    var $strConfigName;
    var $strTimeZone = STOCK_TIME_ZONE_CN;  // Time zone for $strDate and $strTime display
    var $strExternalLink = false;          // External link help to interprete the original data
    
    // original data
    var $strPrice;                    // Current trading price string
    var $strPrevPrice;               // Previous close price string
    var $strDate;                     // 2014-11-13
    var $strTime;			            // 08:55:00        
    
    var $strChineseName;
    var $strName = '';
    
    var $strOpen;                     // open price
    var $strHigh;
    var $strLow;
    var $strVolume = '0';
    
    var $arBidPrice = array();
    var $arBidQuantity = array();
    var $arAskPrice = array();
    var $arAskQuantity = array();

    var $bHasData = true;
    var $extended_ref = false;          // US stock extended trading StockReference
    
    function StockReference($sym)
    {
   		$this->sym = $sym;
        $this->strConfigName = DebugGetConfigFileName($sym->GetSymbol());

        $this->strPrice = rtrim0($this->strPrice);
        $this->strPrevPrice = rtrim0($this->strPrevPrice);
    }

    function HasData()
    {
    	return $this->bHasData;
    }
    
    function SetCurPrice($strPrice)
    {
   		$this->strPrice = rtrim0($strPrice);
    }
    
    function GetCurPrice()
    {
        return $this->strPrice;
    }
    
    function SetPrevPrice($strPrevPrice)
    {
    	$this->strPrevPrice = rtrim0($strPrevPrice);
    }
    
    function GetPrevPrice()
    {
        return $this->strPrevPrice;
    }
    
    function EmptyFile()
    {
        unlinkEmptyFile($this->strFileName);
    }
    
    function GetStockSymbol()
    {
        return $this->sym->GetSymbol();
    }

    function GetExternalLink()
    {
        return $this->strExternalLink;
    }
    
    function SetExternalLink($strLink)
    {
   		$this->strExternalLink = $strLink;
    }
    
    function GetDescription()
    {
    	return $this->strDescription;
    }
    
    function SetDescription($str)
    {
    	$this->strDescription = $str;
    }
    
    function GetSym()
    {
        return $this->sym;
    }

    // for weixin text
    function GetPriceText($fVal)
    {
        return strval_round($fVal, $this->sym->GetPrecision());
    }

    function GetPercentageText($strPrevPrice)
    {
    	if (empty($strPrevPrice) || empty($this->strPrice))		return '';
    
   		$fPercentage = StockGetPercentage($this->strPrice, $strPrevPrice);
   		return strval_round($fPercentage, 2).'%';
    }
    
    // for display
    function GetPercentageDisplay($strPrevPrice)
    {
    	if (abs(floatval($this->strPrice) - floatval($strPrevPrice)) < 0.0005)
    	{
    		$strDisplay = '0';
    		$strColor = 'grey';
    	}
    	else
    	{
    		$strDisplay = $this->GetPercentageText($strPrevPrice);
    		if (substr($strDisplay, 0, 1) == '-')	$strColor = 'red';
    		else                                   		$strColor = 'black';
    	}
    	return "<font color=$strColor>$strDisplay</font>";
    }
    
    function GetCurrentPercentage()
    {
        return StockGetPercentage($this->strPrice, $this->strPrevPrice);
    }
    
    function GetCurrentPercentageDisplay()
    {
        return $this->GetPercentageDisplay($this->strPrevPrice);
    }
    
    function GetPriceDisplay($strPrice, $bPrev = true)
    {
        return StockGetPriceDisplay($strPrice, ($bPrev ? $this->strPrevPrice : $this->strPrice), $this->sym->GetPrecision());
    }

    function GetCurrentPriceDisplay()
    {
        return $this->GetPriceDisplay($this->strPrice);
    }

    function ConvertDateTime($iTime, $strTimeZone)
    {
        list($this->strDate, $this->strTime) = explodeDateTime($iTime, $strTimeZone);
    }
    
    function DebugLink()
    {
        return GetFileDebugLink($this->strFileName);
    }
    
    function DebugConfigLink()
    {
        return GetFileDebugLink($this->strConfigName);
    }
    
    // Oct 17 09:31AM EDT
    function _convertDateTimeFromUS($strDateTime)
    {
        $this->ConvertDateTime(strtotime($strDateTime), STOCK_TIME_ZONE_US);
        $this->strTimeZone = STOCK_TIME_ZONE_US;
        
        $ymd = new StringYMD($this->strDate);
        if ($ymd->IsFuture())
        {   // Dec 30 04:00PM EST, an extra year bug caused by strtotime function
            $iYear = intval($ymd->arYMD[0]);
            $iYear --;
            $this->strDate = strval($iYear).'-'.$ymd->arYMD[1].'-'.$ymd->arYMD[2];
        }
    }
    
    function GetDate()
    {
        return $this->strDate;
    }
    
    function GetDateTime()
    {
        return $this->strDate.' '.$this->strTime;
    }
    
    function _totime($strTimeZone)
    {
        date_default_timezone_set($strTimeZone);
        return strtotime($this->GetDateTime());
    }
    
    function CheckAdjustFactorTime($etf_ref)
    {
        if ($etf_ref == false)                           return false;
        if ($etf_ref->HasData() == false)                 return false;
        
        if ($this->strTimeZone == $etf_ref->strTimeZone)
        {
            $strDate = $this->strDate;
            $strTime = $this->strTime;
        }
        else
        {
            $iTime = $this->_totime($this->strTimeZone);
            list($strDate, $strTime) = explodeDateTime($iTime, $etf_ref->strTimeZone);
        }
        if ($strDate != $etf_ref->strDate)                          return false;
        if (GetTimeHM($strTime) != GetTimeHM($etf_ref->strTime))    return false;
        
        return true;
    }
    
    function LoadYahooData($sym)
    {
        $strSymbol = $sym->GetSymbol();
        $this->strFileName = DebugGetYahooFileName($strSymbol);
        $this->strExternalLink = GetYahooStockLink($sym);
        $strYahooSymbol = $sym->GetYahooSymbol();
        $str = _getYahooStr($sym, $strYahooSymbol, $this->strFileName);
        if (IsYahooStrError($str))
        {
//            $this->EmptyFile();
            $this->bHasData = false;
            return;
        }
        $str = _replaceCommaInsideQuotationMarks($str);
        
        $ar = explode(',', $str);
        if ($ar[0] == 'N/A' && $ar[1] == 'N/A' && $ar[2] == 'N/A' && $ar[3] == 'N/A' && $ar[4] == 'N/A')
        {
            $this->bHasData = false;
            return;
        }
        $this->strName = str_replace(COMMA_REPLACEMENT, ',', RemoveDoubleQuotationMarks($ar[3]));
        
        $this->strPrice = $ar[0];
//        $this->strPrevPrice = strval(floatval($this->strPrice) / (1 + _convertYahooPercentage($ar[2])));
        $this->strPrevPrice = $ar[5];         // p
        $this->strDate = _convertYahooDate($ar[4]);
        $this->strTime = _convertYahooTime($ar[1]);
        if ($sym->IsSymbolUS())
        {
            $this->strTimeZone = STOCK_TIME_ZONE_US;
        }
        else
        {
            $iTime = $this->_totime(STOCK_TIME_ZONE_US);
            $this->ConvertDateTime($iTime, STOCK_TIME_ZONE_CN);
        }
        
        $this->strOpen = $ar[6];               // o
        $this->strLow = $ar[7];                // g
        $this->strHigh = $ar[8];               // h
        $this->strVolume = $ar[9];             // v
    }

    function _generateUsTradingDateTime()
    {
        $this->strTimeZone = STOCK_TIME_ZONE_US;
/*        $iTime = time();
        $localtime = localtime($iTime);
        $iHour = $localtime[2];
        if ($iHour < 9 || ($iHour == 9 && $localtime[1] < 30))
        {
            $iTime -= SECONDS_IN_DAY;
            $localtime = localtime($iTime);
            $iTime = mktime(16, 1, 0, $localtime[4] + 1, $localtime[3], 1900 + $localtime[5]);
        }*/
        $now_ymd = new NowYMD();
        $iTime = $now_ymd->GetTick();
        $iHour = $now_ymd->GetHour();
        $iMinute = $now_ymd->GetMinute();
        if ($iHour < 9 || ($iHour == 9 && $iMinute < 30))
        {
            $ymd = new TickYMD($iTime - SECONDS_IN_DAY);
            $iTime = mktime(16, 1, 0, $ymd->GetMonth(), $ymd->GetDay(), $ymd->GetYear());
        }
        $this->ConvertDateTime($iTime, $this->strTimeZone);
    }
    
    function LoadGoogleData($sym)
    {
   		$this->strExternalLink = GetGoogleStockLink($sym);
    	if ($strGoogleSymbol = $sym->GetGoogleSymbol())
    	{
    		$this->strFileName = DebugGetGoogleFileName($sym->GetSymbol());
    		$ar = _getGoogleArray($sym, $strGoogleSymbol, $this->strFileName);

    		$this->strPrice = str_replace(',', '', $ar['l']);
    		$strChange = str_replace(',', '', $ar['c']);
    		$this->strPrevPrice = strval(floatval($this->strPrice) - floatval($strChange));
    		$this->_generateUsTradingDateTime();
    		return;
    	}
        $this->bHasData = false;
        
//        $this->strPrice = $ar['l_fix'];
//        $this->strPrevPrice = $ar['pcls_fix'];
//        $this->_convertDateTimeFromUS($ar['lt']);
/*      can not use this because google has CDT timezone data!
        // 2017-04-10T16:35:52Z
        list($this->strDate, $strTime) = explode('T', $ar['lt_dts']);
        $this->strTime = rtrim($strTime, 'Z');
        if ($sym->IsSymbolUS())
        {
            $this->strTimeZone = STOCK_TIME_ZONE_US;
        }
        else
        {   // to do ...
        }
*/        
    }
    
    function _onSinaDataHK($ar)
    {
        $this->strPrevPrice = $ar[3];
        $this->strPrice = $ar[6];
        $this->strDate = str_replace('/', '-', $ar[17]);    // 2016/03/02
        $this->strTime = $ar[18];
/*        if (_HasSinaRealtimeHkData($strSymbol) == false)
        {   // 16:01
            $this->strTime .= ':00';
        }*/

        $this->strOpen = $ar[2];
        $this->strHigh = $ar[4];
        $this->strLow = $ar[5];
        $this->strVolume = $ar[12];
        
        $this->strName = $ar[0];
        $this->strChineseName = $ar[1];
    }
    
    function _onSinaDataUS($ar, $sym)
    {
        $this->strName = $ar[0];
        $this->strPrice = $ar[1];
        $this->strPrevPrice = $ar[26];
        if ($ar[25] != '')
        {
            $this->_convertDateTimeFromUS($ar[25]);
        }
        else
        {
            $this->_generateUsTradingDateTime();
        }
        
        $this->strOpen = $ar[5];
        $this->strHigh = $ar[6];
        $this->strLow = $ar[7];
        $this->strVolume = $ar[10];
        
		if (!empty($ar[24]))
		{
			$this->extended_ref = new ExtendedTradingReference($ar, $sym);
			$this->extended_ref->strFileName = $this->strFileName;
		}
    }
    
    function _onSinaDataCN($ar)
    {
        $this->strPrevPrice = $ar[2];
        $this->strPrice = $ar[3];
        $this->strDate = $ar[30];
        $this->strTime = $ar[31];
        $this->strName = $ar[0];
        
        $this->strOpen = $ar[1];
        $this->strHigh = $ar[4];
        $this->strLow = $ar[5];
        $this->strVolume = $ar[8];
        
        for ($i = 10; $i < 20; $i += 2)
        {
            $this->arBidQuantity[] = $ar[$i];
            $this->arBidPrice[] = $ar[$i + 1];
            $this->arAskQuantity[] = $ar[$i + 10];
            $this->arAskPrice[] = $ar[$i + 11];
        }
    }
    
    function LoadSinaData($sym)
    {
    	$this->strExternalLink = GetSinaStockLink($sym);
        if ($strSinaSymbol = $sym->GetSinaSymbol())
        {
        	$this->strFileName = DebugGetSinaFileName($strSinaSymbol);
        	$ar = _getSinaArray($sym, $strSinaSymbol, $this->strFileName);
        	if (count($ar) >= 18)
        	{
        		if ($sym->IsSymbolA())
        		{
        			$this->_onSinaDataCN($ar);
        			return;
        		}
        		else if ($sym->IsSymbolH())
        		{
        			$this->_onSinaDataHK($ar);
        			return;
        		}
       			$this->_onSinaDataUS($ar, $sym);
       			return;
        	}
        }
        $this->bHasData = false;
        // DebugString($this->strFileName.' LoadSinaData found NO data');
    }
    
    function _onSinaFuture($ar)
    {
        $this->strPrice = $ar[0];
        $this->strTime = $ar[6];
        $this->strPrevPrice = $ar[7];
        $this->strDate = $ar[12];
        $this->strName = $ar[13];

        $this->strOpen = $ar[8];
        $this->strHigh = $ar[4];
        $this->strLow = $ar[5];
        $this->strVolume = $ar[9];
    }
    
    function _onSinaFutureCN($ar)
    {
//        $this->strPrice = $ar[8];
        $this->strPrice = $ar[9];
        $this->strTime = substr($ar[1], 0, 2).':'.substr($ar[1], 2, 2).':'.substr($ar[1], 4, 2);
        $this->strPrevPrice = $ar[10];
        $this->strDate = $ar[17];
        $this->strName = $ar[15].'-'.$ar[0];

        $this->strOpen = $ar[2];
        $this->strHigh = $ar[3];
        $this->strLow = $ar[4];
        $this->strVolume = $ar[14];
    }
    
    function LoadSinaFutureData($sym)
    {
        $this->strExternalLink = GetSinaFutureLink($sym);
        $strSymbol = $sym->GetSymbol();
        $this->strFileName = DebugGetSinaFileName($strSymbol);
        $ar = _GetForexAndFutureArray($strSymbol, $this->strFileName, ForexAndFutureGetTimezone(), 'GetSinaQuotes');
        if (count($ar) < 13)
        {
            $this->bHasData = false;
            return;
        }
        
        if ($sym->IsSinaFutureUs())
        {
            $this->_onSinaFuture($ar);
        }
        else
        {
            $this->_onSinaFutureCN($ar);
        }
    }
    
    function LoadSinaFundData($sym)
    {
        $this->strExternalLink = GetSinaFundLink($sym);
        if ($sym->IsSinaFund())	$strFundSymbol = $sym->GetSymbol();
        else						$strFundSymbol = $sym->GetSinaFundSymbol();
        
        $strFileName = DebugGetSinaFileName($strFundSymbol);
        $this->strFileName = $strFileName;

        if (($str = IsNewDailyQuotes($sym, $strFileName, '_GetFundQuotesYMD')) === false)
        {
        	$str = GetSinaQuotes($strFundSymbol);
        	if ($str)   file_put_contents($strFileName, $str);
        	else         $str = file_get_contents($strFileName);
        }
        
        $ar = explodeQuote($str);
        if (count($ar) < 4)
        {
            $this->bHasData = false;
            return;
        }
        
        $this->strPrice = $ar[1];   // net value
        $this->strPrevPrice = $ar[3];
        
        $this->strDate = $ar[4];
        $this->strName = $ar[0];
    }
    
    function _getEastMoneyForexData($ar)
    {
    	$this->strName = $ar[1];
    	$this->strChineseName = $ar[2];
    	$this->strPrevPrice = $ar[3];
    	$this->strOpen = $ar[4];
    	$this->strPrice = $ar[5];
    	list($this->strDate, $this->strTime) = GetEastMoneyForexDateTime($ar); 
    }
    
    function LoadEastMoneyCnyData($sym)
    {
		$strSymbol = $sym->GetSymbol();
        $this->strFileName = DebugGetEastMoneyFileName($strSymbol);
        if (($str = IsNewDailyQuotes($sym, $this->strFileName, _GetEastMoneyQuotesYMD)) === false)
        {
            $str = GetEastMoneyQuotes(ForexGetEastMoneySymbol($strSymbol));
            if ($str)   file_put_contents($this->strFileName, $str);
            else         $str = file_get_contents($this->strFileName);
        }
        
        $this->_getEastMoneyForexData(explodeQuote($str));
//        if (floatval($this->strOpen) > MIN_FLOAT_VAL)   $this->strPrice = $this->strOpen;
//        else                                               $this->strPrice = $this->strPrevPrice;
        $this->strPrice = $this->strOpen;
        
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
    }
    
    function LoadSinaForexData($sym)
    {
        $this->strExternalLink = GetSinaForexLink($sym);
    	$strSymbol = $sym->GetSymbol();
        $this->strFileName = DebugGetSinaFileName($strSymbol);
        $ar = _GetForexAndFutureArray($strSymbol, $this->strFileName, ForexAndFutureGetTimezone(), 'GetSinaQuotes');
        if (count($ar) < 10)
        {
            $this->bHasData = false;
            return;
        }
        
        $this->strTime = $ar[0];
        $this->strPrevPrice = $ar[3];
        $this->strPrice = $ar[8];
    	$this->strName = $ar[9];
//        $this->strDate = $ar[10];
		$this->strDate = end($ar);
    }       

    function LoadEastMoneyForexData($strSymbol)
    {
        $this->strExternalLink = GetEastMoneyForexLink($strSymbol);
        $this->strFileName = DebugGetEastMoneyFileName($strSymbol);
        $ar = _GetForexAndFutureArray(ForexGetEastMoneySymbol($strSymbol), $this->strFileName, ForexAndFutureGetTimezone(), 'GetEastMoneyQuotes');
        if (count($ar) < 27)
        {
            $this->bHasData = false;
            return;
        }
        $this->_getEastMoneyForexData($ar);
    }       

    function LoadSqlData($sql)
    {
       	if ($record = $sql->GetNow())
       	{
   			$this->strPrice = $record['close'];
   			$this->strDate = $record['date'];
   			$this->strPrevPrice = $sql->GetClosePrev($this->strDate);
   		}
    }

    function Debug($iVal = false)
    {
    	if (empty($this->sym))
    	{
    		DebugVal($iVal, 'sym NOT set');
    	}
    	
    	if ($this->sym->IsSymbolA())
    	{
    		DebugHere($iVal);
    	}
 	}
}

// ****************************** ExtendedTrading Class *******************************************************

class ExtendedTradingReference extends StockReference
{
    function ExtendedTradingReference($ar, $sym)
    {
        $this->strExternalLink = GetYahooStockLink($sym);
        $this->strPrice = $ar[21];
        $this->_convertDateTimeFromUS($ar[24]);
        $this->strPrevPrice = $ar[26];
//        $this->strVolume = $ar[27];
        $this->strVolume = strstr($ar[27], '.', true);

        $iHour = intval(substr($this->strTime, 0, 2));
        
        parent::StockReference($sym);
        if ($iHour <= STOCK_HOUR_BEGIN)
        {
            $this->strDescription = STOCK_PRE_MARKET;
        }
        else
        {
            $this->strDescription = STOCK_POST_MARKET;
        }
    }
}

// ****************************** YahooNetValueReference Class *******************************************************

class YahooNetValueReference extends StockReference
{
    function YahooNetValueReference($strStockSymbol)
    {
    	$strSymbol = GetYahooNetValueSymbol($strStockSymbol);
		$sym = new StockSymbol($strSymbol);
        $this->LoadYahooData($sym);
        parent::StockReference($sym);
        $this->strDescription = STOCK_NET_VALUE;
    }
}

// ****************************** Public StockReference functions *******************************************************
function RefHasData($ref)
{
	if ($ref == false)	return false;
	return $ref->HasData();
}

function RefGetMyStockLink($ref)
{
    return GetMyStockLink($ref->GetStockSymbol());
}

function RefSetExternalLinkMyStock($ref)
{
   	$ref->SetExternalLink(RefGetMyStockLink($ref));
}

function RefSetExternalLink($ref)
{
	$strSymbol = $ref->GetStockSymbol();
	$strLink = GetStockLink($strSymbol);
   	if ($strLink == false)
    {
    	$strLink = GetMyStockLink($strSymbol);
    }
	$ref->SetExternalLink($strLink);
}

?>
