<?php

class YearMonthDay
{
    var $iTime;
    var $local;     // localtime
    
    function YearMonthDay($iTick) 
    {
        $this->iTime = $iTick;
        $this->SetLocal();
    }
    
    function SetLocal()
    {
        $this->local = localtime($this->iTime);
    }

    function GetYMD()
    {
        return DebugGetDate($this->iTime, false);
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
    
    function NeedFile($strFileName, $iInterval = SECONDS_IN_MIN)
    {
   		$iFileTime = filemtime($strFileName);
   		return ($this->GetTick() < ($iFileTime + $iInterval)) ? false : $iFileTime;
    }
    
    function IsFuture() 
    {
        return ($this->GetTick() > time()) ? true : false;
    }
    
    function IsMonday()
    {
        return ($this->local[6] == 1) ? true : false;
    }
    
    function IsFriday()
    {
        return ($this->local[6] == 5) ? true : false;
    }
    
    function IsSaturday()
    {
        return ($this->local[6] == 6) ? true : false;
    }
    
    function IsSunday()
    {
        return ($this->local[6] == 0) ? true : false;
    }
    
    function IsWeekDay()
    {
        return ($this->IsSaturday() || $this->IsSunday()) ? false : true;
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
    
    function GetMonth()
    {
        return $this->local[4] + 1;
    }
    
    function GetDay()
    {
        return $this->local[3];
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

class StringYMD extends YearMonthDay
{
    function StringYMD($strYMD)
    {
        $arYMD = explode('-', $strYMD);
        if (count($arYMD) != 3)
        {
        	DebugString('Invalid StringYMD input: '.$strYMD);
        	$iTick = time();
        }
        else
        {
        	$iTick = mktime(0, 0, 0, intval($arYMD[1]), intval($arYMD[2]), intval($arYMD[0]));
        }
        parent::YearMonthDay($iTick);
    }
}

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

class TickYMD extends YearMonthDay
{
    function TickYMD($iTick)
    {
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
    
    function GetHourMinute()
    {
        return intval($this->GetHour()) * 100 + intval($this->GetMinute());
    }
    
    function GetHMS()
    {
		return DebugGetTime($this->iTime, false);
    }
    
    function IsStockTradingHourEnd()
    {
    	if ($this->GetHour() <= 16)	return false;
    	return true;
    }
    
    function IsFutureMarketTrading()
    {
    	$iHour = $this->GetHour();
    	if ($this->IsSunday())
    	{
    		if ($iHour < 18)		return false;
    	}
    	else if ($this->IsSaturDay())
    	{
    		if ($iHour >= 17)		return false;
    	}
    	else
    	{
    		if ($iHour == 17)		return false;
    	}
    	return true;
    }
}

function GetNextTradingDayYMD($strYMD)
{
    $ymd = new StringYMD($strYMD);
    $iTick = $ymd->GetNextTradingDayTick();
    
    $next_ymd = new TickYMD($iTick);
    return $next_ymd->GetYMD();
}

class NowYMD extends TickYMD
{
    var $strTimeZone;
    
    function NowYMD()
    {
        parent::TickYMD(time());
        $this->strTimeZone = date_default_timezone_get();
    }
    
    function CheckTimeZone()
    {
    	$str = date_default_timezone_get();
    	if ($str != $this->strTimeZone)
    	{
    		$this->SetLocal();				// timezone have changed
    		$this->strTimeZone = $str;
    	}
    }
}

function GetNowTick()
{
	global $g_now_ymd;
	return $g_now_ymd->GetTick(); 
}

function GetNowYMD()
{
	global $g_now_ymd;
	
	$g_now_ymd->CheckTimeZone();
	return $g_now_ymd;
}

    $g_now_ymd = new NowYMD();
?>
