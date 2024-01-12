<?php

// 'JST'
function ConvertYMD($strDate)
{
	return substr($strDate, 0, 4).'-'.substr($strDate, 4, 2).'-'.substr($strDate, 6, 2);
}

class YearMonthDay
{
    var $iTime;
    var $local;     // localtime
    
    public function __construct($iTick) 
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
    
    function GetDisplay($bChinese)
    {
    	return $bChinese ? date("Y年n月j日", $this->iTime) : date("M j, Y", $this->iTime);
    }
    
    function GetMonthDayDisplay($bChinese)
    {
    	return $bChinese ? date("n月j日", $this->iTime) : date("M j", $this->iTime);
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
    public function __construct($strYMD)
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
        parent::__construct($iTick);
    }
}

class OldestYMD extends StringYMD
{
    public function __construct()
    {
        parent::__construct('2014-01-01');
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
    
    public function __construct()
    {
        $this->strTimeZone = 'PRC';
    	date_default_timezone_set($this->strTimeZone);
        
        parent::__construct(time());
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
	return $g_now_ymd ? $g_now_ymd->GetTick() : 1; 
}

function GetNowYMD()
{
	global $g_now_ymd;
	
	$g_now_ymd->CheckTimeZone();
	return $g_now_ymd;
}

    $g_now_ymd = new NowYMD();
?>
