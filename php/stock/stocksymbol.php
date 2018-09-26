<?php

define('SINA_FUTURE_PREFIX', 'hf_');
define('SINA_FUND_PREFIX', 'f_');
define('SINA_HK_PREFIX', 'rt_hk');
define('SINA_US_PREFIX', 'gb_');

define('SHANGHAI_PREFIX', 'SH');
define('SHENZHEN_PREFIX', 'SZ');

define('YAHOO_INDEX_CHAR', '^');

define('INDEXSP_PREFIX', 'INDEXSP:');
define('INDEXDJX_PREFIX', 'INDEXDJX:');
define('INDEXCBOE_PREFIX', 'INDEXCBOE:');

define('STOCK_TIME_ZONE_CN', 'PRC');
define('STOCK_TIME_ZONE_US', 'America/New_York');

function in_array_lower($strSymbol, $callback)
{
    return in_array(strtolower($strSymbol), call_user_func($callback));
}

function ChinaEtfGetSymbolArray()
{
    return array('sh510300', 'sh510330', 'sz159919');
}

function in_arrayChinaEtf($strSymbol)
{
    return in_array_lower($strSymbol, ChinaEtfGetSymbolArray);
}

function AdrGetSymbolArray()
{
    return array('ach', 'cea', 'chu', 'gsh', 'hnp', 'lfc', 'ptr', 'shi', 'snp', 'znh');
}

function GoldEtfGetSymbolArray()
{
    return array('sh518800', 'sh518880', 'sz159934', 'sz159937', 'sz161226'); 
}

function in_arrayGoldEtf($strSymbol)
{
    return in_array_lower($strSymbol, GoldEtfGetSymbolArray);
}

function GradedFundGetSymbolArray()
{
    return array('sh502004', 'sz150022', 'sz150152', 'sz150169', 'sz150175', 'sz150181', 'sz150186', 'sz150200', 'sz150205', 'sz150209', 'sz150223', 'sz150277', 'sz150287'); 
}

function in_arrayGradedFund($strSymbol)
{
    return in_array_lower($strSymbol, GradedFundGetSymbolArray);
}

function LofGetChinaInternetSymbolArray()
{
    return array('sh513050', 'sz164906');
}

function in_arrayChinaInternetLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetChinaInternetSymbolArray);
}

function LofGetGoldSymbolArray()
{
    return array('sz160719', 'sz161116', 'sz164701'); 
}

function in_arrayGoldLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetGoldSymbolArray);
}

function LofGetOilSymbolArray()
{
    return array('sh501018', 'sz160216', 'sz160723', 'sz161129'); 
}

function in_arrayOilLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetOilSymbolArray);
}

function LofGetOilEtfSymbolArray()
{
    return array('sz160416', 'sz162411', 'sz162719', 'sz163208'); 
}

function in_arrayOilEtfLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetOilEtfSymbolArray);
}

function LofGetBricSymbolArray()
{
    return array('sz161714', 'sz165510');
}

function in_arrayBricLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetBricSymbolArray);
}

function LofGetCommoditySymbolArray()
{
    return array('sz161815', 'sz165513'); 
}

function LofGetQqqSymbolArray()
{
    return array('sh513100', 'sz159941'); 
}

function in_arrayQqqLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetQqqSymbolArray);
}

function LofGetSpySymbolArray()
{
    return array('sh513500', 'sz161125'); 
}

function in_arraySpyLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetSpySymbolArray);
}

function LofGetSymbolArray()
{
    $ar = array('sh513030', 'sz160140', 'sz161126', 'sz161127', 'sz161128', 'sz162415'); 
    $ar = array_merge($ar, LofGetChinaInternetSymbolArray()
    						, LofGetGoldSymbolArray()
    						, LofGetOilSymbolArray()
    						, LofGetOilEtfSymbolArray()
    						, LofGetBricSymbolArray()
    						, LofGetCommoditySymbolArray()
    						, LofGetQqqSymbolArray()
    						, LofGetSpySymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayLof($strSymbol)
{
    return in_array_lower($strSymbol, LofGetSymbolArray);
}

function LofHkGetHSharesSymbolArray()
{
    return array('sh510900', 'sz160717');
}

function in_arrayHSharesLofHk($strSymbol)
{
    return in_array_lower($strSymbol, LofHkGetHSharesSymbolArray);
}

function LofHkGetHangSengSymbolArray()
{
    return array('sh513660', 'sz159920', 'sz160924');
}

function in_arrayHangSengLofHk($strSymbol)
{
    return in_array_lower($strSymbol, LofHkGetHangSengSymbolArray);
}

function LofHkGetSymbolArray()
{
    $ar = array('sh501021', 'sh501025'); 
    $ar = array_merge($ar, LofHkGetHSharesSymbolArray()
    						, LofHkGetHangSengSymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayLofHk($strSymbol)
{
    return in_array_lower($strSymbol, LofHkGetSymbolArray);
}

function GetAllSymbolArray()
{
	$ar = LofGetSymbolArray();
	$ar = array_merge($ar, LofHkGetSymbolArray()
							, GradedFundGetSymbolArray()
							, GoldEtfGetSymbolArray()
							, ChinaEtfGetSymbolArray()
							, AdrGetSymbolArray());
    return $ar;
}

function in_arrayAll($strSymbol)
{
    return in_array_lower($strSymbol, GetAllSymbolArray);
}

function IsChineseStockDigit($strDigit)
{
    if (is_numeric($strDigit))
    {
        if (strlen($strDigit) == 6)
        {
            return $strDigit;
        }
    }
    return false;
}

function _isShenzhenFundDigit($iDigit)
{
    if ($iDigit >= 100000 && $iDigit < 200000)  return true;
    return false;
}

function _isShanghaiFundDigit($iDigit)
{
    if ($iDigit >= 500000 && $iDigit < 600000)  return true;
    return false;
}

function _isShenzhenIndexDigit($iDigit)
{
    if ($iDigit >= 390000 && $iDigit < 400000)  return true;
    return false;
}

function _isShanghaiIndexDigit($iDigit)
{
    if ($iDigit >= 000000 && $iDigit < 100000)  return true;
    return false;
}

// ****************************** StockSymbol Class *******************************************************

class StockSymbol
{
    var $strSymbol;              // Stock symbol
    
    // Index start with ^
    var $strFirstChar = false;
    var $strOthers;
    
    // Chinese market
    var $strDigitA = false;     // 162411
    var $iDigitA;
    var $strPrefixA;            // SH or SZ

    // Hongkong
    var $iDigitH = -1;
    var $strSinaIndexH = false;
    
    // US
    var $strSinaIndexUS = false;
    
    function _getFirstChar()
    {
        if ($this->strFirstChar == false)
        {
            $strSymbol = $this->strSymbol;
            $this->strFirstChar = substr($strSymbol, 0, 1);
            $this->strOthers = substr($strSymbol, 1);
        }
    }
    
    function IsIndex()
    {
        $this->_getFirstChar();
        if ($this->strFirstChar == YAHOO_INDEX_CHAR)
        {
            return true;
        }
        return false;
    }
    
    function IsSymbolUS()
    {
        if ($this->IsSymbolA())     return false;
        if ($this->IsSymbolH())     return false;
        return true;
    }
    
    function IsSymbolH()
    {
        if ($this->iDigitH >= 0)   return true;
        
        $strSymbol = $this->strSymbol;
        if ($this->IsIndex())
        {
            if ($strSymbol == '^HSI' || $strSymbol == '^HSCE' || $strSymbol == '^SPHCMSHP')
            {
                $this->iDigitH = 0;
                return true;
            }
        }
        else if ($this->strFirstChar == '0')
        {
            if (is_numeric($strSymbol))
            {
                if (strlen($strSymbol) == 5)
                {
                    $this->iDigitH = intval($strSymbol);
                    return true;
                }
            }
        }
        return false;
    }
    
    function IsSymbolA()
    {
        if ($this->strDigitA)   return $this->strDigitA;
        
        $strSymbol = $this->strSymbol;
        $strDigit = substr($strSymbol, 2);
        if (IsChineseStockDigit($strDigit))
        {
            $strPrefix = strtoupper(substr($strSymbol, 0, 2));
            if ($strPrefix == SHANGHAI_PREFIX || $strPrefix == SHENZHEN_PREFIX)
            {
                $this->strPrefixA = $strPrefix;
                $this->iDigitA = intval($strDigit);
                $this->strDigitA = $strDigit;
                return $strDigit;
            }
        }
        return false;
    }
    
    function IsFundA()
    {
        if ($this->strDigitA == false)
        {
            if ($this->IsSymbolA() == false)    return false;
        }
        
        if ($this->strPrefixA == SHENZHEN_PREFIX && _isShenzhenFundDigit($this->iDigitA))   return $this->strDigitA;
        if ($this->strPrefixA == SHANGHAI_PREFIX && _isShanghaiFundDigit($this->iDigitA))   return $this->strDigitA;
        return false;
    }
    
    function IsIndexA()
    {
        if ($this->strDigitA == false)
        {
            if ($this->IsSymbolA() == false)    return false;
        }
        
        if ($this->strPrefixA == SHENZHEN_PREFIX && _isShenzhenIndexDigit($this->iDigitA))   return $this->strDigitA;
        if ($this->strPrefixA == SHANGHAI_PREFIX && _isShanghaiIndexDigit($this->iDigitA))   return $this->strDigitA;
        return false;
    }
    
    function IsStockA()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->IsIndexA())	return false;
    		if ($this->IsFundA())		return false;
    		return true;
    	}
    	return false;
    }
    
    function IsEtf()
    {
    	if ($this->IsIndex() || $this->IsIndexA())	return false;
    	return true;
    }
    
    function IsEastMoneyForex()
    {
        $strSymbol = $this->strSymbol;
        if ($strSymbol == 'USCNY' || $strSymbol == 'HKCNY')
        {
            return true;
        }
        return false;
    }
    
    function IsSinaForex()
    {
        $strSymbol = $this->strSymbol;
        if ($strSymbol == 'DINIW')
        {
            return true;
        }
        return false;
    }
    
    function IsForex()
    {
    	if ($this->IsEastMoneyForex())	return true;
    	if ($this->IsSinaForex())			return true;
    	return false;
    }
    
    // f_240019
    function IsSinaFund()
    {
    	$strSinaSymbol = $this->strSymbol;
        if (substr($strSinaSymbol, 0, 2) == SINA_FUND_PREFIX)
        {
            $strDigit = substr($strSinaSymbol, 2);
            return IsChineseStockDigit($strDigit);
        }
        return false;
    }
    
    // AUO, AG1712
    function IsFutureCn()
    {
        if ($this->IsSymbolA())                   return false;

        $this->_getFirstChar();
        if (is_numeric($this->strFirstChar))    return false;
        
        if (is_numeric(substr($this->strSymbol, -1, 1)))  return true;
        return false;
    }

    function IsSinaFuture()
    {
    	$strSinaSymbol = $this->strSymbol;
        if ($this->IsFutureCn())					                   return $strSinaSymbol;
        if (substr($strSinaSymbol, 0, 3) == SINA_FUTURE_PREFIX)    return substr($strSinaSymbol, 3);
        return false;
    }
    
    function GetSinaFutureSymbol()
    {
    	$strSymbol = $this->strSymbol;
    	if ($this->IsFutureCn())
    	{   // AU0
    		return $strSymbol;
    	}
    	return SINA_FUTURE_PREFIX.$strSymbol;
    }
    
    function IsTradable()
    {
    	if ($this->IsIndex())			return false;
    	if ($this->IsIndexA())		return false;
    	if ($this->IsForex())			return false;
    	if ($this->IsSinaFuture())	return false;
    	return true;
    }
    
    function SetTimeZone()
    {
        if ($this->IsSymbolA() || $this->IsSymbolH() || $this->IsEastMoneyForex() || $this->IsSinaFund())
        {
            $strTimeZone = STOCK_TIME_ZONE_CN;
        }
        else
        {
            $strTimeZone = STOCK_TIME_ZONE_US;
        }
        date_default_timezone_set($strTimeZone);
    }

    function GetSinaFundSymbol()
    {
        if ($this->IsFundA())   return SINA_FUND_PREFIX.$this->strDigitA;
        DebugString('GetSinaFundSymbol() exception '.$this->strSymbol);
        return false;
    }
    
    function GetSinaIndexH()
    {
    	if ($this->strSinaIndexH == false)
    	{
    		$strSymbol = $this->strSymbol;
    		if ($strSymbol == '^HSI')			$this->strSinaIndexH = 'HSI';
    		else if ($strSymbol == '^HSCE')   $this->strSinaIndexH = 'HSCEI';
    	}
    	return $this->strSinaIndexH;
    }
    
    function GetSinaIndexUS()
    {
    	if ($this->strSinaIndexUS == false)
    	{
    		$strSymbol = $this->strSymbol;
    		if ($strSymbol == '^DJI')     	  $this->strSinaIndexUS = 'dji';  
            else if ($strSymbol == '^GSPC')    $this->strSinaIndexUS = 'inx';  
            else if ($strSymbol == '^NDX')     $this->strSinaIndexUS = 'ndx';  
    	}
    	return $this->strSinaIndexUS;
    }
    
    function GetSinaSymbol()
    {
        $strSymbol = str_replace('.', '', $this->strSymbol);
        $strLower = strtolower($strSymbol);
        if ($this->IsIndex())
        {
			if ($this->GetSinaIndexH())		    return SINA_HK_PREFIX.$this->strSinaIndexH;
			else if ($this->GetSinaIndexUS())	return SINA_US_PREFIX.$this->strSinaIndexUS;
            else                                   return false;
        }
        else if ($this->IsSymbolH())
        {   // Hongkong market
            return SINA_HK_PREFIX.$strSymbol;    
        }
        else if ($this->IsSymbolA())
        {
            return $strLower;
        }
        return SINA_US_PREFIX.$strLower;
    }

/*上证综指代码：000001.ss，深证成指代码：399001.SZ，沪深300代码：000300.ss 下面就是世界股票交易所的网址和缩写，要查找哪个股票交易所的数据，就按照上面的格式以此类推。
上海交易所 .SS
深圳交易所 .SZ
加拿大     .TO,Toronto
新西兰     .NZ
新加坡     .SI
香港       .HK
台湾       .TW
印度       .BO,Bombay
伦敦       .L
澳洲       .AX
巴西       .SA,Sao Paulo
瑞典       .ST,Stockholm
*/
    function GetYahooSymbol()
    {
        $strSymbol = str_replace('.', '-', $this->strSymbol);
        if ($this->IsIndex())
        {
            return '%5E'.$this->strOthers;   // index ^HSI
        }
        else if ($this->IsSymbolH())
        {
            return $this->strOthers.'.hk';   // Hongkong market
        }
        else if ($this->IsSymbolA())
        {
            if ($this->strPrefixA == SHANGHAI_PREFIX)
            {
                return $this->strDigitA.'.ss';   // Shanghai market
            }
            else if ($this->strPrefixA == SHENZHEN_PREFIX)
            {
                return $this->strDigitA.'.sz';   // Shenzhen market
            }
        }
        return $strSymbol;
    }
    
    function GetFtSymbol()
    {
        if ($this->IsIndex())
        {
        	if ($this->strSymbol == '^SPSIOP')												return $this->strOthers.':IOM';
        	else if ($this->strSymbol == '^SPGOGUP' || $this->strSymbol == '^SPBRICNTR')	return $this->strOthers.':REU';
        	else if ($this->strSymbol == '^DJSOEP')											return $this->strOthers.':DJI';
        	else if ($this->strSymbol == '^IXY')												return $this->strOthers.':PSE';
        }
        return false;
    }
    
/* 
    function GetMarketWatchSymbol()
    {
        if ($this->IsIndex())
        {
            return strtolower($this->strOthers);   // index ^SPSIOP
        }
        return false;
    }
*/    
    function GetGoogleSymbol()
    {
/*        $strSymbol = $this->strSymbol;
        if ($this->IsIndex())
        {
            $str = $this->strOthers;
            if ($strSymbol == '^GSPC')  return INDEXSP_PREFIX.'.INX';
            else if ($strSymbol == '^SPSIOP' || $strSymbol == '^SPGOGUP' || $strSymbol == '^SPBRICNTR' || $strSymbol == '^IXY')  return INDEXSP_PREFIX.$str;
            else if ($strSymbol == '^VIX')      return INDEXCBOE_PREFIX.$str;
            else if ($strSymbol == '^DJSOEP')   return INDEXDJX_PREFIX.$str;
        }*/
//        return $strSymbol;
        return false;
    }
    
    function GetSymbol()
    {
        return $this->strSymbol;
    }
    
    // constructor 
    function StockSymbol($strSymbol)
    {
        $this->strSymbol = $strSymbol;
    }
}

?>
