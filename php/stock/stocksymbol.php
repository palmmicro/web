<?php

// http://hq.sinajs.cn/list=znb_NKY
// http://hq.sinajs.cn/list=znb_UKX
// http://hq.sinajs.cn/list=znb_DAX
// http://quotes.sina.cn/global/hq/quotes.php?code=NKY
// https://finance.sina.com.cn/futures/quotes/NK.shtml

define('SINA_FOREX_PREFIX', 'fx_s');
define('SINA_FUTURE_PREFIX', 'hf_');
define('SINA_FUND_PREFIX', 'f_');
define('SINA_HK_PREFIX', 'rt_hk');
define('SINA_US_PREFIX', 'gb_');

define('SH_PREFIX', 'SH');
define('SZ_PREFIX', 'SZ');

define('YAHOO_INDEX_CHAR', '^');

define('STOCK_TIME_ZONE_CN', 'PRC');
define('STOCK_TIME_ZONE_US', 'America/New_York');

define('LOF_POSITION_RATIO', 0.95);

function StockCheckSymbol($str)
{
	if (strlen($str) > 10)				return false;
	if (strpos($str, "'") !== false)	return false;
	return $str;
}

function StrHasPrefix($str, $strPrefix)
{
	$iLen = strlen($strPrefix);
	return (strncmp($str, $strPrefix, $iLen) == 0) ? substr($str, $iLen) : false; 
}

function GetSecondaryListingArray()
{
	return array('09988' => 'BABA',
				   '09618' => 'JD',
				   '09999' => 'NTES',
				   '09626' => 'BILI',
				   );
}

function ChinaIndexGetSymbolArray()
{
    return array('SH501043', 'SH510300', 'SH510310', 'SH510330', 'SZ159919');
}

function in_arrayChinaIndex($strSymbol)
{
    return in_array($strSymbol, ChinaIndexGetSymbolArray());
}

function AdrGetSymbolArray()
{
    return array('ACH', 'CEA', 'HNP', 'LFC', 'PTR', 'SHI', 'SNP', 'ZNH');
}

function GoldSilverGetSymbolArray()
{
    return array('SH518800', 'SH518880', 'SZ159934', 'SZ159937', 'SZ161226'); 
}

function in_arrayGoldSilver($strSymbol)
{
    return in_array($strSymbol, GoldSilverGetSymbolArray());
}

function QdiiGetGoldSymbolArray()
{
    return array('SZ160719', 'SZ161116', 'SZ164701'); 
}

function in_arrayGoldQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetGoldSymbolArray());
}

function QdiiGetOilSymbolArray()
{
    return array('SH501018', 'SZ160216', 'SZ160723', 'SZ161129'); 
}

function in_arrayOilQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetOilSymbolArray());
}

function QdiiGetOilEtfSymbolArray()
{
    return array('SZ160416', 'SZ162411', 'SZ162719', 'SZ163208'); 
}

function in_arrayOilEtfQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetOilEtfSymbolArray());
}

function QdiiGetCommoditySymbolArray()
{
    return array('SZ161815', 'SZ165513'); 
}

function in_arrayCommodityQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetCommoditySymbolArray());
}

function QdiiGetQqqSymbolArray()
{
    return array('SH513100', 'SH513300', 'SZ159941', 'SZ161130'); 
}

function in_arrayQqqQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetQqqSymbolArray());
}

function QdiiGetSpySymbolArray()
{
    return array('SH513500', 'SZ161125'); 
}

function in_arraySpyQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetSpySymbolArray());
}

function QdiiGetSymbolArray()
{
    $ar = array_merge(array('SH513030', 'SZ160140', 'SZ161126', 'SZ161127', 'SZ161128', 'SZ162415', 'SZ164824', 'SZ165510') 
    				   , QdiiGetGoldSymbolArray()
    				   , QdiiGetOilSymbolArray()
    				   , QdiiGetOilEtfSymbolArray()
    				   , QdiiGetCommoditySymbolArray()
    				   , QdiiGetQqqSymbolArray()
    				   , QdiiGetSpySymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetSymbolArray());
}

function QdiiHkGetHSharesSymbolArray()
{
    return array('SH510900', 'SZ160717', 'SZ161831');
}

function in_arrayHSharesQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetHSharesSymbolArray());
}

function QdiiHkGetHangSengSymbolArray()
{
    return array('SH501302', 'SH513660', 'SZ159920', 'SZ160924');
}

function in_arrayHangSengQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetHangSengSymbolArray());
}

function QdiiMixGetSymbolArray()
{
    $ar = array('SH513050', 'SZ164906'); 
    return $ar;
}

function in_arrayQdiiMix($strSymbol)
{
    return in_array($strSymbol, QdiiMixGetSymbolArray());
}

function QdiiHkGetSymbolArray()
{
    $ar = array_merge(array('SH501025') 
    				   , QdiiHkGetHSharesSymbolArray()
    				   , QdiiHkGetHangSengSymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetSymbolArray());
}

function GetAllSymbolArray()
{
	return array_merge(QdiiGetSymbolArray()
			            , QdiiMixGetSymbolArray()
			            , QdiiHkGetSymbolArray()
					    , GoldSilverGetSymbolArray()
					    , ChinaIndexGetSymbolArray()
					    , AdrGetSymbolArray());
}

function in_arrayAll($strSymbol)
{
    return in_array($strSymbol, GetAllSymbolArray());
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

function _isDigitShenzhenEtf($iDigit)
{
    return ($iDigit >= 150000 && $iDigit <= 159999) ? true : false;
}

function _isDigitShenzhenLof($iDigit)
{
    return ($iDigit >= 160000 && $iDigit <= 169999) ? true : false;
}

function _isDigitShenzhenFund($iDigit)
{
	if (_isDigitShenzhenEtf($iDigit))		return true;
	if (_isDigitShenzhenLof($iDigit))		return true;
	return false;
}

function _isDigitShanghaiEtf($iDigit)
{
    return ($iDigit >= 510000 && $iDigit <= 518999) ? true : false;
}

function _isDigitShanghaiLof($iDigit)
{
    return ($iDigit >= 500000 && $iDigit <= 509999) ? true : false;
}

function _isDigitShanghaiFund($iDigit)
{
	if (_isDigitShanghaiEtf($iDigit))		return true;
	if (_isDigitShanghaiLof($iDigit))		return true;
	return false;
}

function _isDigitShenzhenB($iDigit)
{
    return ($iDigit >= 200000 && $iDigit < 300000) ? true : false;
}

function _isDigitShanghaiB($iDigit)
{
    return ($iDigit >= 900000 && $iDigit < 1000000) ? true : false;
}

function _isDigitShenzhenIndex($iDigit)
{
    return ($iDigit >= 390000 && $iDigit < 400000) ? true : false;
}

function _isDigitShanghaiIndex($iDigit)
{
    return ($iDigit >= 000000 && $iDigit < 100000) ? true : false;
}

function BuildChineseFundSymbol($strDigit)
{
    if (IsChineseStockDigit($strDigit))
    {
        $iDigit = intval($strDigit);
        if (_isDigitShanghaiFund($iDigit))		$strPrefix = SH_PREFIX;
        else if (_isDigitShenzhenFund($iDigit))	$strPrefix = SZ_PREFIX;
        else										return false;		// $strPrefix = SINA_FUND_PREFIX;
        return $strPrefix.$strDigit;
    }
    return false;
}            

function BuildChineseStockSymbol($strDigit)
{
    if (IsChineseStockDigit($strDigit))
    {
        $iDigit = intval($strDigit);
        if (($iDigit < 100000) || ($iDigit >= 200000 && $iDigit < 400000))	return SZ_PREFIX.$strDigit;
        else if ($iDigit >= 600000)												return SH_PREFIX.$strDigit;
    }
    return false;
}

function BuildHongkongStockSymbol($strDigit)
{
	$iLen = strlen($strDigit);
	if ($iLen != 5)
	{
		for ($i = $iLen; $i < 5; $i ++)
		{
			$strDigit = '0'.$strDigit;
		}
	}
	return $strDigit;
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
            if ($strSymbol == '^HSI' || $strSymbol == '^HSCE')
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
    
    function GetDigitA()
    {
        return $this->strDigitA;
    }
    
    function IsSymbolA()
    {
        if ($this->strDigitA)   return $this->strDigitA;
        
        $strSymbol = $this->strSymbol;
        $strDigit = substr($strSymbol, 2);
        if (IsChineseStockDigit($strDigit))
        {
            $strPrefix = strtoupper(substr($strSymbol, 0, 2));
            if ($strPrefix == SH_PREFIX || $strPrefix == SZ_PREFIX)
            {
                $this->strPrefixA = $strPrefix;
                $this->iDigitA = intval($strDigit);
                $this->strDigitA = $strDigit;
                return $strDigit;
            }
        }
        return false;
    }

    function IsShangHaiA()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->strPrefixA == SH_PREFIX)	return true;
        }
        return false;
	}
	
    function IsShenZhenA()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->strPrefixA == SZ_PREFIX)	return true;
        }
        return false;
	}
	
    function IsShangHaiEtf()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShanghaiEtf($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShangHaiLof()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShanghaiLof($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShenZhenEtf()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenzhenEtf($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShenZhenLof()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenzhenLof($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsLofA()
    {
        if ($this->IsShenZhenLof())	return true;
        if ($this->IsShangHaiLof())	return true;
        return false;
    }
    
    function IsEtfA()
    {
        if ($this->IsShenZhenEtf())	return true;
        if ($this->IsShangHaiEtf())	return true;
        return false;
    }
    
    function IsFundA()
    {
        if ($this->IsLofA() || $this->IsEtfA())		return $this->strDigitA;
        return false;
    }
    
    function IsIndexA()
    {
        if ($this->strDigitA == false)
        {
            if ($this->IsSymbolA() == false)    return false;
        }
        
        if ($this->strPrefixA == SZ_PREFIX && _isDigitShenzhenIndex($this->iDigitA))   return $this->strDigitA;
        if ($this->strPrefixA == SH_PREFIX && _isDigitShanghaiIndex($this->iDigitA))   return $this->strDigitA;
        return false;
    }
    
    function IsStockB()
    {
        if ($this->strDigitA == false)
        {
            if ($this->IsSymbolA() == false)    return false;
        }
        
        if ($this->strPrefixA == SZ_PREFIX && _isDigitShenzhenB($this->iDigitA))   return $this->strDigitA;
        if ($this->strPrefixA == SH_PREFIX && _isDigitShanghaiB($this->iDigitA))   return $this->strDigitA;
        return false;
    }
    
    function IsEtf()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->IsIndexA())	return false;
    		if ($this->IsStockB())	return false;
    		
    		if ($this->IsFundA())		return true;
    	}
    	else
    	{
    		if ($this->IsIndex())		return false;
    	}
    	return true;
    }
    
    function IsEastMoneyForex()
    {
        switch ($this->strSymbol)
        {
        case 'USCNY':
        case 'HKCNY':
            return true;
        }
        return false;
    }
    
    function IsNewSinaForex()
    {
    	return StrHasPrefix($this->strSymbol, SINA_FOREX_PREFIX); 
    }
    
    function IsOldSinaForex()
    {
        switch ($this->strSymbol)
        {
        case 'DINIW':
            return true;
        }
        return false;
    }
    
    function IsSinaForex()
    {
    	if ($this->IsNewSinaForex())	return true;
    	if ($this->IsOldSinaForex())	return true;
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
        if ($strDigit = StrHasPrefix($this->strSymbol, SINA_FUND_PREFIX))
        {
            return IsChineseStockDigit($strDigit);
        }
        return false;
    }
    
    // AUO, AG1712
    function IsSinaFutureCn()
    {
        if ($this->IsSymbolA())                   return false;

        $this->_getFirstChar();
        if (is_numeric($this->strFirstChar))    return false;
        
        if (is_numeric(substr($this->strSymbol, -1, 1)))  return true;
        return false;
    }

    function IsSinaFutureUs()
    {
    	return StrHasPrefix($this->strSymbol, SINA_FUTURE_PREFIX); 
    }
    
    function IsSinaFuture()
    {
        if ($this->IsSinaFutureCn())	return true;
        if ($this->IsSinaFutureUs())	return true;
        return false;
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
    		switch ($this->strSymbol)
    		{
    		case '^HSI':
    			$this->strSinaIndexH = 'HSI';
    			break;
    			
    		case '^HSCE':
    			$this->strSinaIndexH = 'HSCEI';
    			break;
    		}
    	}
    	return $this->strSinaIndexH;
    }
    
    function GetSinaIndexUS()
    {
    	if ($this->strSinaIndexUS == false)
    	{
    		switch ($this->strSymbol)
    		{
    		case '^DJI':
    			$this->strSinaIndexUS = 'dji';
    			break;
    			
    		case '^GSPC':
    			$this->strSinaIndexUS = 'inx';
    			break;
    			
    		case '^NDX':
    			$this->strSinaIndexUS = 'ndx';
    			break;
    		}
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

/*上证综指代码: 000001.ss, 深证成指代码: 399001.SZ, 沪深300代码: 000300.ss 下面就是世界股票交易所的网址和缩写, 要查找哪个股票交易所的数据, 就按照上面的格式以此类推. 
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
            if ($this->strPrefixA == SH_PREFIX)
            {
                return $this->strDigitA.'.ss';   // Shanghai market
            }
            else if ($this->strPrefixA == SZ_PREFIX)
            {
                return $this->strDigitA.'.sz';   // Shenzhen market
            }
        }
        return $strSymbol;
    }
    
    function GetPrecision()
    {
    	if ($this->IsSinaFund() || $this->IsFundA())   	return 3;
    	else if ($this->IsForex())   					return 4;
    	return 2;
    }
    
    function IsTradable()
    {
    	if ($this->IsIndex())			return false;
    	if ($this->IsIndexA())		return false;
    	if ($this->IsForex())			return false;
    	if ($this->IsSinaFuture())	return false;
    	return true;
    }
    
    function IsBeforeStockMarket($iHourMinute)
    {
   		if ($this->IsSymbolA())
   		{
   			if ($iHourMinute < 915)		return true;
   		}
   		else if ($this->IsSymbolH())
   		{	// Hongkong market from 9:00 to 16:10
   			if ($iHourMinute < 900)		return true;
   		}
   		else
   		{   // US extended hours trading from 4am to 8pm
   			if ($iHourMinute < 400)		return true;
    	}

    	return false;
    }
    
    function IsAfterStockMarket($iHourMinute)
    {
   		if ($this->IsSymbolA())
   		{
			if ($iHourMinute > 1505)
    		{
    			if ($this->IsShangHaiA() && ($this->iDigitA >= 688000))
    			{
    				if ($iHourMinute > 1535)		return true;
    			}
   				else								return true;
   			}
   		}
   		else if ($this->IsSymbolH())
   		{	// Hongkong market from 9:00 to 16:10
   			if ($iHourMinute > 1615)				return true;
   		}
   		else
   		{   // US extended hours trading from 4am to 8pm
   			if ($iHourMinute > 2005)				return true;
    	}

    	return false;
    }
    
    function IsStockMarketTrading($ymd)
    {
    	if ($ymd->IsWeekDay())
    	{
    		$iHourMinute = $ymd->GetHourMinute();
   			if ($this->IsBeforeStockMarket($iHourMinute))					return false;
   			else if ($this->IsAfterStockMarket($iHourMinute))				return false;
   			else
   			{
   				if ($this->IsSymbolA())
   				{
   					if (($iHourMinute > 1140) && ($iHourMinute < 1300))	return false;		// SH000300 update until 1135
   				}
   				else if ($this->IsSymbolH())
   				{	// Hongkong market from 9:00 to 16:10
   					if (($iHourMinute > 1200) && ($iHourMinute < 1300))
   					{
   						if ($this->IsIndex() == false)		    			return false;		// ^HSCE and ^HSI continue to trade during this period
   					}
   				}
    		}
    	}
    	else																	return false;   // do not trade on weekend

    	return true;
    }

    function GetTimeZone()
    {
    	$strTimeZone = STOCK_TIME_ZONE_CN;
        if ($this->IsSinaFund())     
        {   // IsSinaFund must be called before IsSinaFuture
        }
        else if ($this->IsSinaFuture())
        {
        }
        else if ($this->IsSinaForex())
        {
        }
        else if ($this->IsEastMoneyForex())
        {
        }
        else if ($this->IsSymbolA() || $this->IsSymbolH())
        {
        }
        else
        {
            $strTimeZone = STOCK_TIME_ZONE_US;
        }
        return $strTimeZone;
    }

    function SetTimeZone()
    {
    	$strTimeZone = $this->GetTimeZone();
        if (date_default_timezone_get() != $strTimeZone)		date_default_timezone_set($strTimeZone);
    }

    function GetMoneyDisplay()
    {
    	if ($this->IsSymbolA())           $strMoney = '';
    	else if ($this->IsSymbolH())     $strMoney = 'HK$';
    	else                               $strMoney = '$';
    	return $strMoney;
    }
    
    public function GetSymbol()
    {
        return $this->strSymbol;
    }
    
    function StockSymbol($strSymbol)
    {
        $this->strSymbol = $strSymbol;
    }
}

?>
