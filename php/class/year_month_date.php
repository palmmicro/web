<?php

// ****************************** YearMonthDate Class *******************************************************

class YearMonthDate
{
    var $strYMD;
    
    var $iTime;
    var $local;     // localtime
    
    // constructor 
    function YearMonthDate($iTick) 
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
    
    function IsWeekend()
    {
        if ($this->IsWeekDay())     return false;
        return true;
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
        
        $ymd_next = new YearMonthDate($iTick);
        if ($ymd_next->IsHoliday())
        {
            return $ymd_next->GetNextTradingDayTick();
        }
        return $iTick;
    }
}

// ****************************** YMDString *******************************************************

class YMDString extends YearMonthDate
{
    var $arYMD;
    
    // constructor 
    function YMDString($strYMD)
    {
        $this->strYMD = $strYMD;
        $this->arYMD = explode('-', $strYMD);
        $iTick = mktime(0, 0, 0, $this->arYMD[1], $this->arYMD[2], $this->arYMD[0]);
        parent::YearMonthDate($iTick);
    }
}

// ****************************** YMDTick *******************************************************

class YMDTick extends YearMonthDate
{
    // constructor 
    function YMDTick($iTick)
    {
        $this->strYMD = date(DEBUG_DATE_FORMAT, $iTick);
        parent::YearMonthDate($iTick);
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
