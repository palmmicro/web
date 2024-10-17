<?php

// SZ164212 SH501226 SZ159696

/* https://finance.sina.com.cn/money/globalindex/ 
https://finance.sina.com.cn/money/globalindex/asia.shtml
gb_dji,gb_ixic,gb_inx,
znb_UKX,znb_DAX,znb_INDEXCF,znb_CAC,znb_SMI,znb_FTSEMIB,znb_MADX,znb_OMX,znb_HEX,znb_OSEAX,znb_ISEQ,znb_AEX,znb_IBEX,znb_SX5E,znb_XU100,znb_NKY,znb_TWJQ,znb_FSSTI,znb_KOSPI,znb_FBMKLCI,znb_SET,znb_JCI,znb_PCOMP,znb_KSE100,znb_SENSEX,znb_VNINDEX,znb_CSEALL,znb_SASEIDX,znb_SPTSX,znb_MEXBOL,znb_IBOV,znb_MERVAL,znb_AS51,znb_NZSE50FG,znb_CASE,znb_JALSH
*/

define('SINA_FOREX_PREFIX', 'fx_s');
define('SINA_FUTURE_PREFIX', 'hf_');
define('SINA_FUND_PREFIX', 'f_');
define('SINA_INDEX_PREFIX', 'znb_');
define('SINA_HK_PREFIX', 'rt_hk');
define('SINA_US_PREFIX', 'gb_');

define('BJ_PREFIX', 'BJ');
define('SH_PREFIX', 'SH');
define('SZ_PREFIX', 'SZ');

define('YAHOO_INDEX_CHAR', '^');

function StrHasPrefix($str, $strPrefix)
{
	$iLen = strlen($strPrefix);
	return (strncmp($str, $strPrefix, $iLen) == 0) ? substr($str, $iLen) : false; 
}

function GetSecondaryListingArray()
{
	return array(
				   'BABA' => '09988',
				   'BIDU' => '09888',
				   'BILI' => '09626',
				   'JD' => '09618',
				   'NTES' => '09999',
				   'TCOM' => '09961',
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
    return array('SZ160416', 'SZ162719', 'SZ163208'); 
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
    return array('SH513100', 'SH513110', 'SH513300', 'SH513390', 'SH513870', 'SZ159501', 'SZ159513', 'SZ159632', 'SZ159659', 'SZ159660', 'SZ159696', 'SZ159941', 'SZ161130'); 
}

function in_arrayQqqQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetQqqSymbolArray());
}

function QdiiGetSpySymbolArray()
{
    return array('SH513500', 'SH513650', 'SZ159612', 'SZ159655', 'SZ161125'); 
}

function in_arraySpyQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetSpySymbolArray());
}

function QdiiGetXopSymbolArray()
{
    return array('SH513350', 'SZ159518', 'SZ162411'); 
}

function in_arrayXopQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetXopSymbolArray());
}

function QdiiGetXbiSymbolArray()
{
    return array('SZ159502', 'SZ161127'); 
}

function in_arrayXbiQdii($strSymbol)
{
    return in_array($strSymbol, QdiiGetXbiSymbolArray());
}

function QdiiGetSymbolArray()
{
    $ar = array_merge(array('SH501300', 'SH513290', 'SH513400', 'SZ160140', 'SZ161126', 'SZ161128', 'SZ162415', 'SZ164824') 
    				   , QdiiGetGoldSymbolArray()
    				   , QdiiGetOilSymbolArray()
    				   , QdiiGetXbiSymbolArray()
    				   , QdiiGetXopSymbolArray()
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

function QdiiHkGetTechSymbolArray()
{
    return array('SH513010', 'SH513130', 'SH513180', 'SH513260', 'SH513380', 'SH513580', 'SH513890', 'SZ159740', 'SZ159741', 'SZ159742');
}

function in_arrayTechQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetTechSymbolArray());
}

function QdiiHkGetHSharesSymbolArray()
{
    return array('SH510900', 'SZ159850', 'SZ159954', 'SZ159960', 'SZ160717', 'SZ161831');
}

function in_arrayHSharesQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetHSharesSymbolArray());
}

function QdiiHkGetHangSengSymbolArray()
{
    return array('SH501302', 'SH513600', 'SH513660', 'SZ159920', 'SZ160924', 'SZ164705');
}

function in_arrayHangSengQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetHangSengSymbolArray());
}

function QdiiHkGetIndexSymbolArray()
{
    return array('^HSI', '^HSCE', '^HSTECH');
}
 
function QdiiHkGetSymbolArray()
{
    $ar = array_merge(array('SH501025') 
    				   , QdiiHkGetTechSymbolArray()
    				   , QdiiHkGetHSharesSymbolArray()
    				   , QdiiHkGetHangSengSymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayQdiiHk($strSymbol)
{
    return in_array($strSymbol, QdiiHkGetSymbolArray());
}

function QdiiJpGetNkySymbolArray()
{
    return array('SH513000', 'SH513520', 'SH513880', 'SZ159866');
}

function in_arrayNkyQdiiJp($strSymbol)
{
    return in_array($strSymbol, QdiiJpGetNkySymbolArray());
}

function QdiiJpGetSymbolArray()
{
    $ar = array_merge(array('SH513800') 
    				   , QdiiJpGetNkySymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayQdiiJp($strSymbol)
{
    return in_array($strSymbol, QdiiJpGetSymbolArray());
}

function QdiiEuGetSymbolArray()
{
    return array('SH513030', 'SH513080', 'SZ159561');
}

function in_arrayQdiiEu($strSymbol)
{
    return in_array($strSymbol, QdiiEuGetSymbolArray());
}

function GetChinaInternetSymbolArray()
{
	return array('SH513050', 'SH513220', 'SZ159605', 'SZ159607', 'SZ164906');
}

function GetMsciUs50SymbolArray()
{
	return array('SH513850', 'SZ159577');
}

function GetHkMixSymbolArray()
{
	return array('SH513090', 'SH513230', 'SH513750', 'SH513990', 'SZ159567', 'SZ159570','SZ159751', 'SZ159792');
}

function in_arrayHkMix($strSymbol)
{
    return in_array($strSymbol, GetHkMixSymbolArray());
}

function QdiiMixGetSymbolArray()
{
    $ar = array_merge(array('SH501225', 'SH501312', 'SH513360', 'SZ159509', 'SZ160644') 
    				   , GetChinaInternetSymbolArray()
    				   , GetHkMixSymbolArray()
    				   , GetMsciUs50SymbolArray());
    sort($ar);
    return $ar;
}

function in_arrayQdiiMix($strSymbol)
{
    return in_array($strSymbol, QdiiMixGetSymbolArray());
}

function GetAllSymbolArray()
{
	return array_merge(QdiiGetSymbolArray()
			            , QdiiMixGetSymbolArray()
			            , QdiiHkGetSymbolArray()
			            , QdiiJpGetSymbolArray()
			            , QdiiEuGetSymbolArray()
					    , ChinaIndexGetSymbolArray()
					    );
}

function in_arrayAll($strSymbol)
{
    return in_array($strSymbol, GetAllSymbolArray());
}

function IsChinaStockDigit($strDigit)
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

function _isDigitShenZhenEtf($iDigit)
{
    return ($iDigit >= 150000 && $iDigit <= 159999) ? true : false;
}

function _isDigitShenZhenLof($iDigit)
{
    return ($iDigit >= 160000 && $iDigit <= 169999) ? true : false;
}

function _isDigitShenZhenB($iDigit)
{
    return ($iDigit >= 200000 && $iDigit < 300000) ? true : false;
}

function _isDigitShenZhenGem($iDigit)	// 创业板 growth enterprise market, GEM
{
    return ($iDigit >= 300000 && $iDigit < 390000) ? true : false;
}

function _isDigitShenZhenIndex($iDigit)
{
    return ($iDigit >= 390000 && $iDigit < 400000) ? true : false;
}

function _isDigitShangHaiIndex($iDigit)
{
    return ($iDigit >= 000000 && $iDigit < 100000) ? true : false;
}

function _isDigitShangHaiEtf($iDigit)
{
    return ($iDigit >= 510000 && $iDigit <= 569999) ? true : false;	// 518999
}

function _isDigitShangHaiLof($iDigit)
{
    return ($iDigit >= 500000 && $iDigit <= 509999) ? true : false;
}

function _isDigitShangHaiStar($iDigit)	// 科创板 SSE STAR Market
{
    return ($iDigit >= 688000 && $iDigit <= 688999) ? true : false;
}

function _isDigitShangHaiB($iDigit)
{
    return ($iDigit >= 900000 && $iDigit < 1000000) ? true : false;
}

function _isDigitShenZhenFund($iDigit)
{
	if (_isDigitShenZhenEtf($iDigit))		return true;
	if (_isDigitShenZhenLof($iDigit))		return true;
	return false;
}

function _isDigitShangHaiFund($iDigit)
{
	if (_isDigitShangHaiEtf($iDigit))		return true;
	if (_isDigitShangHaiLof($iDigit))		return true;
	return false;
}

function BuildChinaFundSymbol($strDigit)
{
    if (IsChinaStockDigit($strDigit))
    {
        $iDigit = intval($strDigit);
        if (_isDigitShangHaiFund($iDigit))		$strPrefix = SH_PREFIX;
        else if (_isDigitShenZhenFund($iDigit))	$strPrefix = SZ_PREFIX;
        else										return false;		// $strPrefix = SINA_FUND_PREFIX;
        return $strPrefix.$strDigit;
    }
    return false;
}            

function BuildChinaStockSymbol($strDigit)
{
    if (IsChinaStockDigit($strDigit))
    {
        $iDigit = intval($strDigit);
        if (($iDigit < 100000) || ($iDigit >= 200000 && $iDigit < 400000))								return SZ_PREFIX.$strDigit;
        else if (($iDigit >= 400000 && $iDigit < 500000) || ($iDigit >= 800000 && $iDigit < 900000))	return BJ_PREFIX.$strDigit;
        else if ($iDigit >= 600000)																			return SH_PREFIX.$strDigit;
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
    
//    https://hq.sinajs.cn/list=rt_hkHSTECH,hkHSTECH_i,rt_hkCSCSHQ
    function IsSymbolH()
    {
        if ($this->iDigitH >= 0)   return true;
        
        $strSymbol = $this->strSymbol;
        if ($this->IsIndex())
        {
            if (in_array($strSymbol, QdiiHkGetIndexSymbolArray()))
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
        if (IsChinaStockDigit($strDigit))
        {
            $strPrefix = strtoupper(substr($strSymbol, 0, 2));
            if ($strPrefix == SH_PREFIX || $strPrefix == SZ_PREFIX || $strPrefix == BJ_PREFIX)
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
	
    function IsBeiJingA()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->strPrefixA == BJ_PREFIX)	return true;
        }
        return false;
	}
	
    function IsShangHaiEtf()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShangHaiEtf($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShangHaiLof()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShangHaiLof($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShangHaiStar()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShangHaiStar($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShangHaiB()
    {
    	if ($this->IsShangHaiA())
    	{
    		if (_isDigitShangHaiB($this->iDigitA))	return $this->strDigitA;
        }
        return false;
    }
    
    function IsShenZhenB()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenZhenB($this->iDigitA))	return $this->strDigitA;
        }
        return false;
    }
    
    function IsShenZhenEtf()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenZhenEtf($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShenZhenLof()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenZhenLof($this->iDigitA))	return true;
        }
        return false;
    }
    
    function IsShenZhenGem()
    {
    	if ($this->IsShenZhenA())
    	{
    		if (_isDigitShenZhenGem($this->iDigitA))	return true;
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
        
        if ($this->strPrefixA == SZ_PREFIX && _isDigitShenZhenIndex($this->iDigitA))   return $this->strDigitA;
        if ($this->strPrefixA == SH_PREFIX && _isDigitShangHaiIndex($this->iDigitA))   return $this->strDigitA;
        return false;
    }
    
    function IsStockB()
    {
   		if ($this->IsShangHaiB())		return true;
   		if ($this->IsShenZhenB())		return true;
   		return false;
    }
    
    function IsEtf()
    {
    	if ($this->IsSymbolA())
    	{
    		if ($this->IsFundA())			return true;
    		if ($this->IsIndexA())		return false;
    		if ($this->IsStockB())		return false;
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
        case 'EUCNY':
        case 'JPCNY':
        case 'HKCNY':
            return true;
        }
        return false;
    }
    
    function IsNewSinaForex()
    {
    	return strtoupper(StrHasPrefix($this->strSymbol, SINA_FOREX_PREFIX)); 
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
            return IsChinaStockDigit($strDigit);
        }
        return false;
    }

    function IsSinaGlobalIndex()
    {
    	return StrHasPrefix($this->strSymbol, SINA_INDEX_PREFIX); 
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
        DebugString(__FUNCTION__.' exception '.$this->strSymbol);
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
    			
    		case '^HSTECH':
    			$this->strSinaIndexH = 'HSTECH';
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
    	if ($this->IsSinaGlobalIndex())			return $this->strSymbol;
    	
        $strSymbol = str_replace('.', '$', $this->strSymbol);
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
    	$strFutureSuffix = '%3DF';	// CL=F
    	$strIndexPrefix = '%5E';		// ^HSI
    	$strHK = '.hk';
    	
        $strSymbol = str_replace('.', '-', $this->strSymbol);
        if ($str = $this->IsSinaFutureUs())
        {
        	switch ($str)
        	{
        	case 'CHA50CFD':
				return 'XIN9.FGI';
				
			default:
				return $str.$strFutureSuffix;	// CL=F
			}
        }
        else if ($str = $this->IsNewSinaForex())
        {
        	switch ($str)
        	{
        	case 'USDCNH':
        		return 'CNH'.$strFutureSuffix;	// CNH=F
        	}
        }
		else if ($str = $this->IsSinaGlobalIndex())
		{
			switch ($str)
			{
			case 'CAC':
				return $strIndexPrefix.'FCHI';
				
			case 'DAX':
				return $strIndexPrefix.'GDAXI';
				
			case 'NKY':
				return $strIndexPrefix.'N225';
				
			case 'SENSEX':
				return $strIndexPrefix.'BSESN';
			}
		}
        else if ($this->IsIndex())
        {
			switch ($strSymbol)
			{
			case '^HSTECH':
				return $this->strOthers.$strHK;
				
			default:
				return $strIndexPrefix.$this->strOthers;	// index ^HSI
			}
        }
        else if ($this->IsSymbolH())													return $this->strOthers.$strHK;	// Hongkong market
        else if ($this->IsSymbolA())
        {
            if ($this->strPrefixA == SH_PREFIX)										return $this->strDigitA.'.ss';	// Shanghai market
            else if ($this->strPrefixA == SZ_PREFIX)									return $this->strDigitA.'.sz';	// Shenzhen market
            else if ($this->strPrefixA == BJ_PREFIX)									return $this->strDigitA.'.bj';	// Beijing market
        }
        return $strSymbol;
    }
    
    function GetPrecision()
    {
    	if ($this->IsSinaFund() || $this->IsFundA() || $this->IsStockB())   	return 3;
    	else if ($this->IsForex())   											return 4;
    	return 2;
    }

    function GetDefaultPosition()
    {
		return $this->IsLofA() ? 0.95 : 1.0;  
    }
    
    function IsTradable()
    {
    	if ($this->IsSinaGlobalIndex())	return false;
    	if ($this->IsIndex())				return false;
    	if ($this->IsIndexA())			return false;
//    	if ($this->IsForex())			return false;
//    	if ($this->IsSinaFuture())	return false;
    	return true;
    }
    
    // https://cn.investing.com/blog/article-193
    function IsBeforeStockMarket($iHourMinute)
    {
    	if ($str = $this->IsSinaGlobalIndex())
    	{
    		switch ($str)
    		{
			case 'CAC':
			case 'DAX':
			case 'NKY':
			case 'TPX':
    			if ($iHourMinute < 900)		return true;
    			break;

			case 'SENSEX':
    			if ($iHourMinute < 1145)		return true;
    			break;
   		}
    	}
   		else if ($this->IsSymbolA())
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
    	if ($str = $this->IsSinaGlobalIndex())
    	{
    		switch ($str)
    		{
			case 'CAC':
			case 'DAX':
    			if ($iHourMinute > 1805)		return true;	// DAX30 指数交易时间为09:00 - 17:30（CET）
    			break;
    			
    		case 'NKY':
			case 'TPX':
    			if ($iHourMinute > 1535)		return true;	// 東證所的交易時間（開盤時間）從上午9點到上午11點30分及 下午0點30分到下午3點的2個時間段
    			break;

			case 'SENSEX':
    			if ($iHourMinute > 1835)		return true;
    			break;
    		}
    	}
   		else if ($this->IsSymbolA())
   		{
			if ($iHourMinute > 1505)
    		{
    			if ($this->IsShangHaiStar() || $this->IsShenZhenGem())
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
    	$strEDT = 'America/New_York';
    	
       	// IsSinaFund must be called before IsSinaFuture
        if ($this->IsSinaFund())								{}
        else if ($this->IsSinaFuture())
        {
        	if ($this->IsSinaFutureUs())						return $strEDT;
        }
        else if ($this->IsSinaForex())						return $strEDT;
        else if ($this->IsEastMoneyForex())					{}
		else if ($str = $this->IsSinaGlobalIndex())
		{
			switch ($str)
			{
			case 'CAC':
				return 'Europe/Paris';
				
			case 'DAX':
				return 'Europe/Berlin';
				
			case 'NKY':
			case 'TPX':
			case 'SENSEX':
				return 'PRC';	//  'Asia/Tokyo';
			}
		}
        else if ($this->IsSymbolA() || $this->IsSymbolH())	{}
        else													return $strEDT;
        return 'PRC';
    }

    function SetTimeZone()
    {
    	$strTimeZone = $this->GetTimeZone();
        if (date_default_timezone_get() != $strTimeZone)		date_default_timezone_set($strTimeZone);
    }
    
    function GetDisplay()
    {
        if ($str = $this->IsSinaFutureUs())		return $str;
        if ($str = $this->IsNewSinaForex())		return $str;
		if ($str = $this->IsSinaGlobalIndex())	return $str;
		return $this->GetSymbol();
    }

    public function GetSymbol()
    {
        return $this->strSymbol;
    }
    
    public function __construct($strSymbol)
    {
        $this->strSymbol = $strSymbol;
    }
}

?>
