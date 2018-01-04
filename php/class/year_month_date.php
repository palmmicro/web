<?php

// ****************************** YearMonthDate Class *******************************************************

class YearMonthDate
{
    var $arYMD;
    var $iTime;
    var $local;     // localtime
    
    // constructor 
    function YearMonthDate($strYMD) 
    {
        if ($strYMD)
        {
            $this->arYMD = explode('-', $strYMD);
            $iTime = mktime(0, 0, 0, $this->arYMD[1], $this->arYMD[2], $this->arYMD[0]);
        }
        else
        {
            $iTime = time();
        }
        $this->SetTick($iTime);
    }

    function SetTick($iTime)
    {
        $this->iTime = $iTime;
        $this->local = localtime($iTime);
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

    function GetNextTradingDayTick()
    {
        $iTick = $this->GetNextWeekDayTick();
        
        $ymd_next = new YearMonthDate(false);
        $ymd_next->SetTick($iTick);
        if ($ymd_next->IsHoliday())
        {
            return $ymd_next->GetNextTradingDayTick();
        }
        return $iTick;
    }
}

?>
