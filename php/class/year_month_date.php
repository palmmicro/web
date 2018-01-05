<?php

// ****************************** YearMonthDay Class *******************************************************

class YearMonthDay
{
    var $strYMD;
    
    var $iTime;
    var $local;     // localtime
    
    // constructor 
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
        if ($this->IsFriday())   $iHours = 3 * 24;
        else                      $iHours = 24;
        return $this->GetTick() + $iHours * SECONDS_IN_HOUR;
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
        
        $ymd_next = new YearMonthDay($iTick);
        if ($ymd_next->IsHoliday())
        {
            return $ymd_next->GetNextTradingDayTick();
        }
        return $iTick;
    }
}

// ****************************** YMDString *******************************************************

class YMDString extends YearMonthDay
{
    var $arYMD;
    
    // constructor 
    function YMDString($strYMD)
    {
        $this->strYMD = $strYMD;
        $this->arYMD = explode('-', $strYMD);
        $iTick = mktime(0, 0, 0, $this->arYMD[1], $this->arYMD[2], $this->arYMD[0]);
        parent::YearMonthDay($iTick);
    }
}

// ****************************** YMDTick *******************************************************

class YMDTick extends YearMonthDay
{
    // constructor 
    function YMDTick($iTick)
    {
        $this->strYMD = date(DEBUG_DATE_FORMAT, $iTick);
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
}

// ****************************** YMDNow *******************************************************

class YMDNow extends YMDTick
{
    // constructor 
    function YMDNow()
    {
        parent::YMDTick(time());
    }
}

?>
