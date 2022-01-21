<?php
// Every market trading from 9 to 17?
define('STOCK_HOUR_BEGIN', 9);
define('STOCK_HOUR_END', 16);

// ****************************** YearMonthDay Class *******************************************************
class YearMonthDay
{
    var $strYMD;
    var $iTime;
    var $local;     // localtime
    
    function YearMonthDay($iTick) 
    {
        $this->iTime = $iTick;
        $this->local = localtime($iTick);
    }

    function GetYMD()
    {
        return $this->strYMD;
    }
    
    function GetTick()
    {
        return $this->iTime;
    }

    function GetNextWeekDayTick()
    {
        if ($this->IsFriday())   			$iSeconds = 3 * SECONDS_IN_DAY;
        else if ($this->IsSaturday())	$iSeconds = 2 * SECONDS_IN_DAY;
        else                      			$iSeconds = SECONDS_IN_DAY;
        return $this->GetTick() + $iSeconds;
    }
    
    function IsNewFile($strFileName, $iInterval = SECONDS_IN_MIN)
    {
   		return ($this->GetTick() < (filemtime($strFileName) + $iInterval)) ? true : false;
    }
    
    function NeedFile($strFileName, $iInterval = SECONDS_IN_MIN)
    {
    	clearstatcache(true, $strFileName);
    	if (file_exists($strFileName))
    	{
    		if ($this->IsNewFile($strFileName, $iInterval))	return false;
    	}
    	return true;
    }
    
    function IsFuture() 
    {
        return ($this->GetTick() > time()) ? true : false;
    }
    
    function IsFriday() 
    {
        return ($this->local[6] == 5) ? true : false;
    }
    
    function IsSaturday() 
    {
        return ($this->local[6] == 6) ? true : false;
    }
    
    function IsWeekDay()
    {
        return ($this->local[6] == 0 || $this->local[6] == 6) ? false : true;
    }
    
    function GetDayOfWeek()
    {
        return $this->local[6];
    }
    
    function IsWeekend()
    {
        return $this->IsWeekDay() ? false : true;
    }
    
    function GetYear()
    {
        return $this->local[5] + 1900;
    }
    
    function GetYearStr()
    {
        return strval($this->GetYear());
    }
    
    function GetMonth()
    {
        return $this->local[4] + 1;
    }
    
    function GetSeason()
    {
    	return intval($this->local[4] / 3) + 1;
    }
    
    function GetMonthStr()
    {
        return strval($this->GetMonth());
    }
    
    function GetDay()
    {
        return $this->local[3];
    }
    
    function GetDayStr()
    {
        return strval($this->GetDay());
    }
    
    function IsHoliday()
    {
        if ($this->local[4] == 0 && $this->local[3] == 1)
        {   // New Years Day is not a trading day everywhere
            return true;
        }
        if ($this->IsWeekend())
        {	// check weekend again for daylight saving bug
        	return true;
        }
        return false;
    }
    
    function IsSameMonth($ymd) 
    {
        return ($ymd->local[4] == $this->local[4]) ? true : false;
    }
    
    function IsSameDay($ymd) 
    {
        return ($ymd->local[3] == $this->local[3]) ? true : false;
    }
    
    function IsSameHour($ymd) 
    {
        return ($ymd->local[2] == $this->local[2]) ? true : false;
    }
    
    function GetNextTradingDayTick()
    {
        $iTick = $this->GetNextWeekDayTick();
        
        $next_ymd = new YearMonthDay($iTick);
        if ($next_ymd->IsHoliday())
        {
            return $next_ymd->GetNextTradingDayTick();
        }
        return $iTick;
    }
}

// ****************************** StringYMD *******************************************************
class StringYMD extends YearMonthDay
{
    var $arYMD;
    
    function StringYMD($strYMD)
    {
        $this->strYMD = $strYMD;
        $this->arYMD = explode('-', $strYMD);
        if (count($this->arYMD) != 3)
        {
        	DebugString('Invalid StringYMD input: '.$strYMD);
        	$iTick = time();
        }
        else
        {
        	$iTick = mktime(0, 0, 0, intval($this->arYMD[1]), intval($this->arYMD[2]), intval($this->arYMD[0]));
        }
        parent::YearMonthDay($iTick);
    }
}

// ****************************** OldestYMD *******************************************************
class OldestYMD extends StringYMD
{
    function OldestYMD()
    {
        parent::StringYMD('2014-01-01');
    }
    
    function IsTooOld($strYMD)
    {
    	$ymd = new StringYMD($strYMD);
    	if ($ymd->GetTick() < $this->GetTick())
    	{
    		DebugString('Date too old '.$strYMD);
    		return true;
    	}
    	return false;
    }
    
    function IsInvalid($strYMD)
    {
    	$ymd = new StringYMD($strYMD);
    	if ($ymd->IsWeekend())
    	{
    		DebugString('Weekend date '.$strYMD);
    		return true;
    	}
    	if ($ymd->IsFuture())
    	{
    		DebugString('Future date '.$strYMD);
    		return true;
    	}
    	return false;
    }
}

// ****************************** TickYMD *******************************************************
class TickYMD extends YearMonthDay
{
	var $strHMS;
	
    function TickYMD($iTick)
    {
        $this->strYMD = date(DEBUG_DATE_FORMAT, $iTick);
        $this->strHMS = date(DEBUG_TIME_FORMAT, $iTick);
        parent::YearMonthDay($iTick);
    }
    
    function GetHour()
    {
        return $this->local[2];
    }
    
    function GetMinute()
    {
        return $this->local[1];
    }
    
    function GetHMS()
    {
    	return $this->strHMS;
    }
    
    function IsTradingHourEnd()
    {
    	if ($this->GetHour() <= STOCK_HOUR_END)	return false;
    	return true;
    }
}

// ****************************** NowYMD *******************************************************
class NowYMD extends TickYMD
{
    function NowYMD()
    {
        parent::TickYMD(time());
    }
}

function GetNextTradingDayYMD($strYMD)
{
    $ymd = new StringYMD($strYMD);
    $iTick = $ymd->GetNextTradingDayTick();
    
    $next_ymd = new TickYMD($iTick);
    return $next_ymd->GetYMD();
}

?>
