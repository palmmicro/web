<?php
require_once('class/ini_file.php');

// max 20 months history used
//define ('MAX_QUOTES_DAYS', 930);
define ('MAX_QUOTES_DAYS', 620);
define ('BOLL_DAYS', 20);

define ('SMA_SECTION', 'SMA');

function _ignoreCurrentTradingData($strDate, $sym)
{        
    $sym->SetTimeZone();
    $ymd = new YMDNow();
    if ($ymd->GetYMD() == $strDate)
    {
        if ($ymd->GetHour() <= STOCK_HOUR_END)
        {   // market still trading, do not use today's data
            return true;
        }
    }
    return false;
}

// ****************************** SMA functions *******************************************************
function _estSma($arF, $iIndex, $iAvg)
{
    $f = 0.0;
    $iNum = $iAvg - 1;
//    $iNum = $iAvg;
    for ($i = 0; $i < $iNum; $i ++)
    {
        $f += $arF[$iIndex + $i];
    }
    return $f / $iNum;
}

// axx + bx + c = 0
function GetQuadraticEquationRoot($a, $b, $c)
{
    $delta = $b * $b - 4.0 * $a * $c;
    if ($delta >= 0.0)
    {
        $x1 = (0.0 - $b + sqrt($delta)) / (2.0 * $a); 
        $x2 = (0.0 - $b - sqrt($delta)) / (2.0 * $a);
//         $strDebug = sprintf('%.2f, %.2f', $x1, $x2);
//         DebugString($strDebug);
        return array($x1, $x2);
    }
    return false;
}

/*
a = (n - 4) * (n - 1)² - 4 * (n - 1)
b = (8 - 2 * (n - 4) * (n - 1)) * ∑Xn
c = (n - 4) * (∑Xn)² - 4 * ∑Xn²
*/
function _estBollingerBands($arF, $iIndex, $iAvg)
{
    $fSum = 0.0;
    $fQuadraticSum = 0.0;
    $iNum = $iAvg - 1;
    for ($i = 0; $i < $iNum; $i ++)
    {
        $fVal = $arF[$iIndex + $i];
        $fSum += $fVal;
        $fQuadraticSum += $fVal * $fVal;
    }
/*    $f = 1.0 * ($iAvg - 4) / 4;
    $a = $f * $iNum * $iNum - $iNum;
    $b = -1.0 * $f * 2 * $iNum * $fSum + 2 * $fSum;
    $c = $f * $fSum * $fSum - $fQuadraticSum;
*/    
    $f = 1.0 * ($iAvg - 4);
    $a = $f * $iNum * $iNum - 4 * $iNum;
    $b = (8 - 2 * $f * $iNum) * $fSum;
    $c = $f * $fSum * $fSum - 4 * $fQuadraticSum;
    
    if ($ar = GetQuadraticEquationRoot($a, $b, $c))
    {
        list($x1, $x2) = $ar;
        $sigma1 = ($fSum - $iNum * $x1) / 2;
        $sigma2 = ($fSum - $iNum * $x2) / 2;
//        $strDebug = sprintf('%.2f, %.2f, %.2f, %.2f', $x1, $x2, $x1 - 2 * $sigma1, $x2 - 2 * $sigma2);
//        DebugString($strDebug);
        return array($x1 - 2 * $sigma1, $x2 - 2 * $sigma2);
    }
    return false;
}

function _estNextBollingerBands($arF, $iAvg)
{
    $fSum = 0.0;
    $fQuadraticSum = 0.0;
    $iNum = $iAvg - 2;
    for ($i = 0; $i < $iNum; $i ++)
    {
        $fVal = $arF[$i];
        $fSum += $fVal;
        $fQuadraticSum += $fVal * $fVal;
    }
    $f = 1.0 * ($iAvg - 8);
    $a = $f * $iNum * $iNum - 16 * $iNum;
    $b = (32 - 2 * $f * $iNum) * $fSum;
    $c = $f * $fSum * $fSum - 16 * $fQuadraticSum;
    
    if ($ar = GetQuadraticEquationRoot($a, $b, $c))
    {
        list($x1, $x2) = $ar;
        $sigma1 = ($fSum - $iNum * $x1) / 4;
        $sigma2 = ($fSum - $iNum * $x2) / 4;
        return array($x1 - 2 * $sigma1, $x2 - 2 * $sigma2);
    }
    return false;
}

// ****************************** Private functions *******************************************************
function _isWeekEnd($strYMD, $strNextDayYMD)
{
    $ymd = new YMDString($strYMD);
    if ($strNextDayYMD)
    {
        $ymd_next = new YMDString($strNextDayYMD);
        if ($ymd->GetDayOfWeek() >= $ymd_next->GetDayOfWeek())     return true;
    }
    else
    { 
        if ($ymd->IsFriday())   return true;
        
        // If this Friday is not a trading day
        $ymd_now = new YMDNow();
        if ($ymd_now->IsWeekDay())
        {
            if ($ymd->GetDayOfWeek() > $ymd_now->GetDayOfWeek())     return true;
        }
        else
        {
            return true;
        }
    }
    return false;
}

function _isMonthEnd($strYMD, $strNextDayYMD)
{
    $ymd = new YMDString($strYMD);
    if ($strNextDayYMD)
    {
        $ymd_next = new YMDString($strNextDayYMD);
    }
    else
    {   // If the last none weekend day of a certain month is not a trading day 
//        $iTick = $ymd->GetNextTradingDayTick();
        $ymd_now = new YMDNow();
        $iTick = $ymd_now->GetNextTradingDayTick();
        $ymd_next = new YMDTick($iTick);
    }
    
    if ($ymd->IsSameMonth($ymd_next))     return false;    // same month    
    return true;
}

// ****************************** StockHistory Class *******************************************************
class StockHistory
{
    var $aiNum;     // days/weeks/months 
    
    var $afSMA = array();
    var $afNext = array();
    var $aiTradingRange = array();

    var $strDate;                     // 2014-11-13
    
    var $stock_ref;     // MyStockReference
    
    function _getTradingRange($iDays, $afClose, $afHigh, $afLow)
    {
        $iFit = 0;
        $iBelow = 0;
        $iAbove = 0; 
        for ($i = 0; $i < 100; $i ++)
        {
            $fAvg = _estSma($afClose, $i + 1, $iDays);
            if (($fAvg - MIN_FLOAT_VAL) > $afHigh[$i])         $iAbove ++;
            else if (($fAvg + MIN_FLOAT_VAL) < $afLow[$i])    $iBelow ++;        
            else                                                  $iFit ++;
        }
        return $iFit;
    }
    
    function _getBollTradingRange($afClose, $afHigh, $afLow)
    {
        $iUpFit = 0;
        $iUpBelow = 0;
        $iUpAbove = 0; 
        $iDownFit = 0;
        $iDownBelow = 0;
        $iDownAbove = 0; 
        for ($i = 0; $i < 100; $i ++)
        {
            list($fUp, $fDown) = _estBollingerBands($afClose, $i + 1, BOLL_DAYS);
            
            if (($fUp - MIN_FLOAT_VAL) > $afHigh[$i])         $iUpAbove ++;
            else if (($fUp + MIN_FLOAT_VAL) < $afLow[$i])    $iUpBelow ++;        
            else                                                  $iUpFit ++;
            
            if (($fDown - MIN_FLOAT_VAL) > $afHigh[$i])         $iDownAbove ++;
            else if (($fDown + MIN_FLOAT_VAL) < $afLow[$i])    $iDownBelow ++;        
            else                                                  $iDownFit ++;
        }
        return array($iUpFit, $iDownFit);
    }
    
    function _buildTradingRangeName($strName)
    {
        return $strName.'Fit';
    }
    
    function _buildNextName($strName)
    {
        return $strName.'Next';
    }
    
    function _cfg_set_SMA($cfg, $strName, $fSma, $fNext, $iTradingRange)
    {
        $this->afSMA[$strName] = $fSma;
        $this->afNext[$strName] = $fNext;
        $this->aiTradingRange[$strName] = $iTradingRange;
        $cfg->set_var(SMA_SECTION, $strName, strval($fSma));
        $cfg->set_var(SMA_SECTION, $this->_buildNextName($strName), strval($fNext));
        $cfg->set_var(SMA_SECTION, $this->_buildTradingRangeName($strName), strval($iTradingRange));
    }
    
    function _cfg_get_SMA($cfg, $strName)
    {
        $this->afSMA[$strName] = floatval($cfg->read_var(SMA_SECTION, $strName));
        $this->afNext[$strName] = floatval($cfg->read_var(SMA_SECTION, $this->_buildNextName($strName)));
        $this->aiTradingRange[$strName] = intval($cfg->read_var(SMA_SECTION, $this->_buildTradingRangeName($strName)));
    }
    
    function _loadConfigSMA($cfg)
    {
        foreach ($this->aiNum as $i)
        {
            $this->_cfg_get_SMA($cfg, 'D'.strval($i));
        }

//        $this->_cfg_get_SMA($cfg, 'EMA50');
//        $this->_cfg_get_SMA($cfg, 'EMA200');
        
        $this->_cfg_get_SMA($cfg, 'BOLLUP');
        $this->_cfg_get_SMA($cfg, 'BOLLDN');
        
        foreach ($this->aiNum as $i)
        {
            $this->_cfg_get_SMA($cfg, 'W'.strval($i));
        }
        
        foreach ($this->aiNum as $i)
        {
            $this->_cfg_get_SMA($cfg, 'M'.strval($i));
        }
    }
    
    function _saveConfigSMA($cfg)
    {
        $afHigh = array();
        $afLow = array();
        $afClose = array();
        $afWeeklyClose = array();
        $afMonthlyClose = array();

        $strNextDayYMD = false;
    	if ($result = SqlGetStockHistoryFromDate($this->GetStockId(), $this->strDate, MAX_QUOTES_DAYS))
    	{
    		while ($history = mysql_fetch_assoc($result)) 
    		{
    			$fClose = floatval($history['adjclose']);
    			$afClose[] = $fClose;
            
    			$fDiff = floatval($history['close']) - $fClose; 
    			$afHigh[] = floatval($history['high']) - $fDiff;
    			$afLow[] = floatval($history['low']) - $fDiff;
    			
    			$strYMD = $history['date'];
    			if (_isWeekEnd($strYMD, $strNextDayYMD))	$afWeeklyClose[] = $fClose;
    			if (_isMonthEnd($strYMD, $strNextDayYMD))	$afMonthlyClose[] = $fClose;
    			$strNextDayYMD = $strYMD;
    		}
    		@mysql_free_result($result);
    	}
        
        foreach ($this->aiNum as $i)
        {
            $this->_cfg_set_SMA($cfg, 'D'.strval($i), _estSma($afClose, 0, $i), _estSma($afClose, 0, $i - 1), $this->_getTradingRange($i, $afClose, $afHigh, $afLow));
        }

//        $this->_cfg_set_SMA($cfg, 'EMA50', _estEma($afClose, 0, 50), -1);
//        $this->_cfg_set_SMA($cfg, 'EMA200', _estEma($afClose, 0, 200), -1);

        list($fUp, $fDown) = _estBollingerBands($afClose, 0, BOLL_DAYS);
        list($fUpNext, $fDownNext) = _estNextBollingerBands($afClose, BOLL_DAYS);
        list($iUp, $iDown) = $this->_getBollTradingRange($afClose, $afHigh, $afLow);
        $this->_cfg_set_SMA($cfg, 'BOLLUP', $fUp, $fUpNext, $iUp);
        $this->_cfg_set_SMA($cfg, 'BOLLDN', $fDown, $fDownNext, $iDown);

        foreach ($this->aiNum as $i)
        {
            $this->_cfg_set_SMA($cfg, 'W'.strval($i), _estSma($afWeeklyClose, 0, $i), _estSma($afWeeklyClose, 0, $i - 1), -1);
        }
            
        foreach ($this->aiNum as $i)
        {
            $this->_cfg_set_SMA($cfg, 'M'.strval($i), _estSma($afMonthlyClose, 0, $i), _estSma($afMonthlyClose, 0, $i - 1),  -1);
        }
        
        $cfg->save_data();
    }
    
    function _configSMA()
    {
        $cfg = new INIFile($this->stock_ref->strConfigName);
        $strCurDate = $this->strDate;
        if ($cfg->group_exists(SMA_SECTION))
        {
            $strDate = $cfg->read_var(SMA_SECTION, 'Date');
            if ($strDate == $strCurDate)
            {
                $this->_loadConfigSMA($cfg);
            }
            else
            {
//                $cfg->add_group(SMA_SECTION);
                $cfg->set_group(SMA_SECTION);
                $cfg->set_var(SMA_SECTION, 'Date', $strCurDate);
                $this->_saveConfigSMA($cfg);
            }
        }
        else
        {
            $cfg->add_group(SMA_SECTION);
            $cfg->set_var(SMA_SECTION, 'Date', $strCurDate);
            $this->_saveConfigSMA($cfg);
        }
    }
    
    function GetStockSymbol()
    {
        return $this->stock_ref->GetStockSymbol();
    }

    function GetStockId()
    {
        return $this->stock_ref->GetStockId();
    }
    
    function _getStartDate()
    {
    	if ($result = SqlGetStockHistory($this->GetStockId(), 0, 2))
    	{
    		while ($history = mysql_fetch_assoc($result)) 
    		{
    			$strDate = $history['date'];
                if (_ignoreCurrentTradingData($strDate, $this->stock_ref->sym))
                {
                	continue;
                }
                else 
                {
                	return $strDate;
                }
            }
        }
        return false;
    }
    
    // constructor 
    function StockHistory($ref) 
    {
        $this->stock_ref = $ref;
//        $this->aiNum = array(5, 10, 20, 30);
        $this->aiNum = array(5, 10, 20);
		$this->strDate = $this->_getStartDate();
        $this->_configSMA();
    }
}

?>
