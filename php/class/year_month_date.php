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
        $this->SetTime($iTime);
    }

    function SetTime($iTime)
    {
        $this->iTime = $iTime;
        $this->local = localtime($this->iTime);
    }
    
    function IsFuture() 
    {
        if ($this->iTime > time())     return true;
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
}

?>
