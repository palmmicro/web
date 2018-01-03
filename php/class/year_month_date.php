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
        $this->arYMD = explode('-', $strYMD);
        $this->iTime = mktime(0, 0, 0, $this->arYMD[1], $this->arYMD[2], $this->arYMD[0]);
        $this->local = localtime($this->iTime);
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
}

?>
