<?php
require_once('stocksymbol.php');

define('STOCK_SINA_DATA', 'Sina Data');
define('STOCK_YAHOO_DATA', 'Yahoo Data (possible 15 min delay)');
define('STOCK_EASTMONEY_DATA', 'East Money Data');
define('STOCK_MYSQL_DATA', 'Data from MySQL');

define('STOCK_NET_VALUE', 'Net Value');
define('STOCK_PRE_MARKET', 'Pre-Market Trading');
define('STOCK_POST_MARKET', 'Post-Market Trading');

// ****************************** Protected functions *******************************************************

function _GetForexAndFutureArray($strSymbol, $strFileName, $strTimeZone, $callback)
{
    if (ForexAndFutureNeedNewFile($strFileName, $strTimeZone))
    {
        $str = call_user_func($callback, $strSymbol);
        if ($str)   file_put_contents($strFileName, $str);
        else         $str = file_exists($strFileName) ? file_get_contents($strFileName) : '';
    }
    else
    {
        $str = file_get_contents($strFileName);
    }
    return explodeQuote($str);
}

// ****************************** Private functions *******************************************************

function _getSinaQuotesStr($strSinaSymbol, $strFileName)
{
    if ($str = GetSinaQuotes($strSinaSymbol))
    {
      	file_put_contents($strFileName, $str);
      	return $str;
    }
	return file_exists($strFileName) ? file_get_contents($strFileName) : '';
}

function _getSinaArray($sym, $strSinaSymbol, $strFileName)
{
    if (StockNeedNewQuotes($sym, $strFileName))
    {
    	$str = _getSinaQuotesStr($strSinaSymbol, $strFileName);
    }
    else
    {
        $str = file_get_contents($strFileName);
    }
    return explodeQuote($str);
}

// ****************************** StockReference Class *******************************************************

class StockReference extends StockSymbol
{
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
    
    function StockReference($strSymbol)
    {
		parent::StockSymbol($strSymbol);
        $this->strConfigName = DebugGetConfigFileName($this->GetSymbol());
    }

    function HasData()
    {
    	return $this->bHasData;
    }
    
    function GetPrice()
    {
        return rtrim0($this->strPrice);
    }
    
    function GetPrevPrice()
    {
        return rtrim0($this->strPrevPrice);
    }
    
    function GetVolume()
    {
    	return $this->strVolume;
    }
    
    function EmptyFile()
    {
        unlinkEmptyFile($this->strFileName);
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
    
    // for weixin text
    function GetPriceText($fVal)
    {
        return strval_round($fVal, $this->GetPrecision());
    }

    function GetPercentage($strDivisor = false, $strDividend = false)
    {
    	if ($strDivisor == false)	$strDivisor = $this->strPrevPrice;
    	if ($strDividend == false)	$strDividend = $this->strPrice;
    	
   		$fPercentage = StockGetPercentage($strDivisor, $strDividend);
   		if ($fPercentage === false)		return '';
   		
   		if ($strDivisor === false)
   		{
//   			if (abs($fPercentage) < 0.001)	return '0';
   		}
   		else
   		{
   			if (abs($fPercentage * floatval($strDivisor)) < (50.0 / pow(10, $this->GetPrecision())))	return '0';
   		}
   		return strval($fPercentage);
    }

    // for display
    function GetPercentageText($strDivisor = false, $strDividend = false)
    {
   		$str = $this->GetPercentage($strDivisor, $strDividend);
   		if ($str != '' && $str != '0')
   		{
   			$str = strval_round(floatval($str), 2).'%';
   		}
   		return $str;
   	}
   	
    function GetPercentageDisplay($strDivisor = false, $strDividend = false)
    {
   		$strDisp = $this->GetPercentageText($strDivisor, $strDividend);
   		if (substr($strDisp, -1, 1) == '%')
   		{
   			$strColor = (substr($strDisp, 0, 1) == '-') ? 'red' : 'black';
   		}
   		else
   		{
   			$strColor = 'gray';
   		}
    	return "<font color=$strColor>$strDisp</font>";
    }
    
    function GetPriceDisplay($strDisp = false, $strPrev = false)
    {
    	if ($strDisp == false)
    	{
    		$strDisp = $this->strPrice;
    		$strPrev = $this->strPrevPrice;
    	}
    	else if ($strPrev == false)
    	{
    		$strPrev = $this->strPrice;
    	}
        return StockGetPriceDisplay($strDisp, $strPrev, $this->GetPrecision());
    }

    function ConvertDateTime($iTime, $strTimeZone)
    {
        $this->strDate = DebugGetDate($iTime, $strTimeZone);
        $this->strTime = DebugGetTime($iTime, $strTimeZone);
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
        
//        DebugString('StringYMD in StockReference->_convertDateTimeFromUS');
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
    
    function GetHour()
    {
        return intval(substr($this->strTime, 0, 2));
    }
    
// 06:56:22 => 06:56
	function GetTimeHM()
	{
		return GetHM($this->strTime);
	}
	
	function IsExtendedMarket()
	{
		if ($this->extended_ref)	return true;
		
		$ar = explode(':', $this->strTime);
		if (count($ar) == 3)
		{
			$iVal = intval($ar[0]);
			$iVal *= 100;
			$iVal += intval($ar[1]);
			$strDebug = $this->GetSymbol().' ';
			if ($iVal < 930)
			{
//				DebugVal($iVal, $strDebug.STOCK_PRE_MARKET);
				return true;
			}
			else if ($iVal > 1600)
			{
//				DebugVal($iVal, $strDebug.STOCK_POST_MARKET);
				return true;
			}
		}
		
		return false;
	}

    function _totime($strTimeZone)
    {
        date_default_timezone_set($strTimeZone);
        return strtotime($this->GetDateTime());
    }
    
    function CheckAdjustFactorTime($etf_ref)
    {
        if ($etf_ref == false)					return false;
        if ($etf_ref->HasData() == false)		return false;
        if ($etf_ref->IsExtendedMarket())				return false;
        
        if ($this->strTimeZone == $etf_ref->strTimeZone)
        {
            $strDate = $this->strDate;
            $strTime = $this->strTime;
        }
        else
        {
            $iTime = $this->_totime($this->strTimeZone);
            $strDate = DebugGetDate($iTime, $etf_ref->strTimeZone);
            $strTime = DebugGetTime($iTime, $etf_ref->strTimeZone);
//            DebugString('CheckAdjustFactorTime: '.$etf_ref->GetSymbol().' '.$etf_ref->GetDate().' '.$etf_ref->GetTimeHM().' vs '.$strDate.' '.$strTime);
        }
        if ($strDate != $etf_ref->GetDate())			return false;
        if (GetHM($strTime) != $etf_ref->GetTimeHM())	return false;
        
        return true;
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
    
    function _onSinaDataHK($ar)
    {
        $this->strPrevPrice = $ar[3];
        $this->strPrice = $ar[6];
        $this->strDate = str_replace('/', '-', $ar[17]);    // 2016/03/02
        $this->strTime = $ar[18];

        $this->strOpen = $ar[2];
        $this->strHigh = $ar[4];
        $this->strLow = $ar[5];
        $this->strVolume = $ar[12];
        
        $this->strName = $ar[0];
        $this->strChineseName = $ar[1];
    }
    
    function _onSinaDataUS($ar)
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
			$this->extended_ref = new ExtendedTradingReference($ar, $this->GetSymbol());
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
    
    function LoadSinaData()
    {
    	$this->strExternalLink = GetSinaStockLink($this);
        if ($strSinaSymbol = $this->GetSinaSymbol())
        {
        	$this->strFileName = DebugGetSinaFileName($strSinaSymbol);
        	$ar = _getSinaArray($this, $strSinaSymbol, $this->strFileName);
        	if (count($ar) >= 18)
        	{
        		if ($this->IsSymbolA())
        		{
        			$this->_onSinaDataCN($ar);
        			return;
        		}
        		else if ($this->IsSymbolH())
        		{
        			$this->_onSinaDataHK($ar);
        			return;
        		}
       			$this->_onSinaDataUS($ar);
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
        $this->strPrice = $ar[8];
//        $this->strPrice = $ar[9];
        $this->strTime = substr($ar[1], 0, 2).':'.substr($ar[1], 2, 2).':'.substr($ar[1], 4, 2);
        $this->strPrevPrice = $ar[10];
        $this->strDate = $ar[17];
        $this->strName = $ar[15].'-'.$ar[0];

        $this->strOpen = $ar[2];
        $this->strHigh = $ar[3];
        $this->strLow = $ar[4];
        $this->strVolume = $ar[14];
    }
    
    function LoadSinaFutureData()
    {
        $this->strExternalLink = GetSinaFutureLink($this);
        $strSymbol = $this->GetSymbol();
        $this->strFileName = DebugGetSinaFileName($strSymbol);
        $ar = _GetForexAndFutureArray($strSymbol, $this->strFileName, ForexAndFutureGetTimezone(), 'GetSinaQuotes');
        if (count($ar) < 13)
        {
            $this->bHasData = false;
            return;
        }
        
        if ($this->IsSinaFutureUs())
        {
            $this->_onSinaFuture($ar);
        }
        else
        {
            $this->_onSinaFutureCN($ar);
        }
    }
    
    function LoadSinaFundData()
    {
        $this->strExternalLink = GetSinaFundLink($this);
        if ($this->IsSinaFund())	$strFundSymbol = $this->GetSymbol();
        else						$strFundSymbol = $this->GetSinaFundSymbol();
        
        $strFileName = DebugGetSinaFileName($strFundSymbol);
        $this->strFileName = $strFileName;

        if (($str = IsNewDailyQuotes($this, $strFileName, '_GetFundQuotesYMD')) === false)
        {
        	$str = _getSinaQuotesStr($strFundSymbol, $strFileName);
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
    
    function LoadEastMoneyCnyData()
    {
		$strSymbol = $this->GetSymbol();
        $this->strFileName = DebugGetEastMoneyFileName($strSymbol);
        if (($str = IsNewDailyQuotes($this, $this->strFileName, _GetEastMoneyQuotesYMD)) === false)
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
    
    function LoadSinaForexData()
    {
        $this->strExternalLink = GetSinaForexLink($this);
    	$strSymbol = $this->GetSymbol();
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

    function LoadEastMoneyForexData()
    {
    	$strSymbol = $this->GetSymbol();
    	
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
       	if ($record = $sql->GetRecordNow())
       	{
   			$this->strPrice = $record['close'];
   			$this->strDate = $record['date'];
   			$this->strPrevPrice = $sql->GetClosePrev($this->strDate);
   		}
    }
}

// ****************************** ExtendedTrading Class *******************************************************

class ExtendedTradingReference extends StockReference
{
    function ExtendedTradingReference($ar, $strSymbol)
    {
        parent::StockReference($strSymbol);
        
        $this->strExternalLink = GetYahooStockLink($this);
        $this->strPrice = $ar[21];
        $this->_convertDateTimeFromUS($ar[24]);
        $this->strPrevPrice = $ar[26];
        
        if (strpos($ar[27], '.'))
        {
        	$this->strVolume = strstr($ar[27], '.', true);
        }
        else
        {
        	$this->strVolume = $ar[27];
        }

        if ($this->GetHour() <= STOCK_HOUR_BEGIN)
        {
            $this->strDescription = STOCK_PRE_MARKET;
        }
        else
        {
            $this->strDescription = STOCK_POST_MARKET;
        }
    }
}

// ****************************** Public StockReference functions *******************************************************
function RefHasData($ref)
{
	if ($ref)
	{
		return $ref->HasData();
	}
	return false;
}

function RefGetMyStockLink($ref)
{
	if ($ref)
	{
		return GetMyStockLink($ref->GetSymbol());
	}
	return '';
}

function RefSetExternalLinkMyStock($ref)
{
	if ($ref)
	{
		$ref->SetExternalLink(RefGetMyStockLink($ref));
	}
}

function RefSetExternalLink($ref)
{
	$strSymbol = $ref->GetSymbol();
	$strLink = GetStockLink($strSymbol);
   	if ($strLink == false)
    {
    	$strLink = GetMyStockLink($strSymbol);
    }
	$ref->SetExternalLink($strLink);
}

?>
