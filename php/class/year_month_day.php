<?php
// Every market trading from 9 to 17?
define ('STOCK_HOUR_BEGIN', 9);
define ('STOCK_HOUR_END', 16);

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
    
    function IsNewFile($strFileName)
    {
        if ($this->GetTick() < (filemtime($strFileName) + SECONDS_IN_MIN))
        {
//        	DebugString($strFileName.' in a minute');
        	return true;
        }
        return false;
    }
    
    function IsFuture() 
    {
        if ($this->GetTick() > time())     return true;
        return false;
    }
    
    function IsFriday() 
    {
        if ($this->local[6] == 5)     return true;
        return false;
    }
    
    function IsSaturday() 
    {
        if ($this->local[6] == 6)     return true;
        return false;
    }
    
    function IsWeekDay()
    {
        if ($this->local[6] == 0 || $this->local[6] == 6)     return false;
        return true;
    }
    
    function GetDayOfWeek()
    {
        return $this->local[6];
    }
    
    function IsWeekend()
    {
        if ($this->IsWeekDay())     return false;
        return true;
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
        return false;
    }
    
    function IsSameMonth($ymd) 
    {
        if ($ymd->local[4] == $this->local[4])     return true;
        return false;
    }
    
    function IsSameDay($ymd) 
    {
        if ($ymd->local[3] == $this->local[3])     return true;
        return false;
    }
    
    function IsSameHour($ymd) 
    {
        if ($ymd->local[2] == $this->local[2])     return true;
        return false;
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
    
    function IsTradingDay()
    {
    	if ($this->IsHoliday())	return false;
    	return $this->IsWeekDay();
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
        $iTick = mktime(0, 0, 0, $this->arYMD[1], $this->arYMD[2], $this->arYMD[0]);
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
    
    function IsInvalid($strYMD)
    {
    	$ymd = new StringYMD($strYMD);
    	if ($ymd->IsWeekend())      return true;
    	if ($ymd->IsFuture())       return true;
    
    	if ($ymd->GetTick() < $this->GetTick())                 return true;
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
    
    function Debug()
    {
    	DebugString($this->strYMD.' '.$this->strHMS);
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

?>
