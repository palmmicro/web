<?php
define('DEBUG_TIME_ZONE', 'PRC');

define('SECONDS_IN_MIN', 60);
define('SECONDS_IN_HOUR', 3600);
define('SECONDS_IN_DAY', 86400);

// 13.6 in MySQL
define('MIN_FLOAT_VAL', 0.000001);

function strval_round($fVal, $iPrecision = false)
{
	if ($iPrecision === false)
	{
		$f = abs($fVal);
		if ($f > (10 - MIN_FLOAT_VAL))		$iPrecision = 2;
		else if ($f > (2 - MIN_FLOAT_VAL))   $iPrecision = 3;
		else                                   $iPrecision = 4;
    }
	return strval(round($fVal, $iPrecision));
}

function strval_round_implode($arVal, $strSeparator = ', ')
{
	$str = '';
	foreach ($arVal as $fVal)
	{
		$str .= strval_round($fVal).$strSeparator;
	}
	return rtrim($str, $strSeparator);
}

function explode_float($str, $strSeparator = ',')
{
	$arF = array();
	$ar = explode($strSeparator, $str);
	foreach ($ar as $str)
	{
		$arF[] = floatval(trim($str));
	}
	return $arF;
}

function rtrim0($str)
{
//	return rtrim($str, '0');
	return strval(floatval($str));
}

function filter_var_email($strEmail)
{
    return filter_var($strEmail, FILTER_VALIDATE_EMAIL);
}

function unlinkEmptyFile($strFileName)
{
	clearstatcache();
	if (file_exists($strFileName))
	{
		if (!unlink($strFileName))
		{
			file_put_contents($strFileName, '');
		}
	}
}

function DebugFormat_date($strFormat, $iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
    if ($strTimeZone)	
    {
    	if ($strTimeZone != date_default_timezone_get())		date_default_timezone_set($strTimeZone);
    }
    return date($strFormat, ($iTime ? $iTime : GetNowTick()));
}

function DebugGetDate($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugFormat_date('Y-m-d', $iTime, $strTimeZone);
}

function DebugGetTime($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugFormat_date('H:i:s', $iTime, $strTimeZone);
}

function DebugGetDateTime($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugGetDate($iTime, $strTimeZone).' '.DebugGetTime($iTime, $strTimeZone);
}

function GetHM($strHMS)
{
	return substr($strHMS, 0, 5);
}

function DebugGetFileTimeDisplay($strPathName)
{
    clearstatcache(true, $strPathName);
    if (file_exists($strPathName))
    {
        return DebugGetDateTime(filemtime($strPathName));
    }
    return '';
}

function DebugGetStopWatchDisplay($fStart, $iPrecision = 2)
{
    return ' ('.strval_round(microtime(true) - $fStart, $iPrecision).'s)';
}

function _checkDebugPath()
{
    $strPath = UrlGetRootDir().'debug';
    if (is_dir($strPath) == false)  mkdir($strPath);
    
    return $strPath;
}

function DebugGetPathName($strFileName)
{
    $strPath = _checkDebugPath();
    return $strPath.'/'.$strFileName; 
}

function DebugGetFile()
{
    return DebugGetPathName('debug.txt');
}

function DebugIsAdmin()
{
   	global $acct;
	if (method_exists($acct, 'IsAdmin'))
	{
		return $acct->IsAdmin();
	}
	return false;
}

function DebugString($str, $bAdminOnly = false)
{
	if ($bAdminOnly)
	{
		if (DebugIsAdmin() == false)		return;
	}
	
	if ($str === false)	$str = '(false)';
	$strTimeZone = date_default_timezone_get();
    file_put_contents(DebugGetFile(), DebugGetTime(time()).' '.UrlGetIp().' '.UrlGetCur().' '.$str.PHP_EOL, FILE_APPEND);	// DebugGetTime will change timezone!
    if ($strTimeZone != DEBUG_TIME_ZONE)		date_default_timezone_set($strTimeZone);
}

function dieDebugString($str)
{
    DebugString($str);
    die($str);
}

function DebugVal($iVal, $strPrefix = false, $bAdminOnly = false)
{
	$str = strval($iVal);
	if ($strPrefix)
	{
		$str = $strPrefix.': '.$str;
	}
 	DebugString($str, $bAdminOnly); 
}

function DebugPrint($exp, $strPrefix = false, $bAdminOnly = false)
{
	$str = $strPrefix ? $strPrefix : 'Debug print_r begin ...';
	$str .= PHP_EOL.print_r($exp, true);
	DebugString($str, $bAdminOnly);
}

function DebugGetPath($strSection)
{
    $strPath = _checkDebugPath(); 
    $strPath .= '/'.$strSection;
    if (is_dir($strPath) == false)  mkdir($strPath);
    
    return $strPath;
}

function DebugGetImageName($str)
{
    $strPath = DebugGetPath('image');
    return "$strPath/$str.jpg";
}

function DebugGetFontName($str)
{
    $strPath = DebugGetPath('font');
    return "$strPath/$str.ttf";
}

function DebugGetChinaMoneyFile()
{
    $strPath = DebugGetPath('chinamoney');
    return "$strPath/json.txt";
}

function DebugGetSymbolFile($strSection, $strSymbol)
{
    $strPath = DebugGetPath($strSection);
    
    $str = strtolower($strSymbol);
    $str = str_replace('+', '_', $str);
    $str = str_replace(',', '_', $str);
    $str = str_replace('^', '_', $str);
    $str = str_replace('.', '_', $str);
    $str = str_replace(':', '_', $str);
    return "$strPath/$str.txt";
}

function DebugGetSinaFileName($strSymbol)
{
    return DebugGetSymbolFile('sina', $strSymbol);
}

function DebugGetYahooWebFileName($strSymbol)
{
    return DebugGetSymbolFile('yahooweb', $strSymbol);
}

function DebugGetConfigFileName($strSymbol)
{
    return DebugGetSymbolFile('config', $strSymbol);
}

function unlinkConfigFile($strSymbol)
{
	unlinkEmptyFile(DebugGetConfigFileName($strSymbol));
}

?>
