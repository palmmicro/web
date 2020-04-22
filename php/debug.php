<?php
require_once('url.php');

define('DEBUG_UTF8_BOM', "\xef\xbb\xbf");

define('DEBUG_FILE_PATH', 'debug');
define('DEBUG_FILE_NAME', 'debug.txt');

define('DEBUG_TIME_ZONE', 'PRC');
define('DEBUG_TIME_FORMAT', 'H:i:s');
define('DEBUG_DATE_FORMAT', 'Y-m-d');

define('SECONDS_IN_MIN', 60);
define('SECONDS_IN_HOUR', 3600);
define('SECONDS_IN_DAY', 86400);

define('MIN_FLOAT_VAL', 0.0000001);

function strval_round($fVal, $iPrecision = false)
{
	if ($iPrecision == false)
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

function unlinkEmptyFile($strFileName)
{
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
    date_default_timezone_set($strTimeZone);
    return date($strFormat, ($iTime ? $iTime : time()));
}

function DebugGetDateTime($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugFormat_date(DEBUG_DATE_FORMAT.' '.DEBUG_TIME_FORMAT, $iTime, $strTimeZone);
}

function DebugGetDate($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugFormat_date(DEBUG_DATE_FORMAT, $iTime, $strTimeZone);
}

function DebugGetTime($iTime = false, $strTimeZone = DEBUG_TIME_ZONE)
{
	return DebugFormat_date(DEBUG_TIME_FORMAT, $iTime, $strTimeZone);
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
    $strPath = UrlGetRootDir().DEBUG_FILE_PATH;
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
    return DebugGetPathName(DEBUG_FILE_NAME);
}

function DebugClear()
{
	file_put_contents(DebugGetFile(), DEBUG_UTF8_BOM.'Start debug:'.PHP_EOL);
}

function DebugString($str)
{
	if ($str == false)	$str = '(false)';
    $strTimeZone = date_default_timezone_get();
    file_put_contents(DebugGetFile(), UrlGetIp().' '.UrlGetCur().' '.DebugGetTime().':'.$str.PHP_EOL, FILE_APPEND);     // DebugGetTime will change timezone!
    date_default_timezone_set($strTimeZone);
}

function dieDebugString($str)
{
    DebugString($str);
    mysql_close();
    die($str);
}

function DebugVal($iVal, $strPrefix = false)
{
	$str = strval($iVal);
	if ($strPrefix)
	{
		$str = $strPrefix.': '.$str;
	}
 	DebugString($str); 
}

function DebugArray($ar)
{
	DebugString('DebugArray begin ...');
	foreach ($ar as $strKey => $strVal)
	{
		DebugString($strKey.' => '.$strVal);
	}
	DebugString('DebugArray end.');
}

function DebugHere($iVal = false)
{
   	static $iDebugVal = 0;
    	
   	if ($iVal)	
   	{
   		$iDebugVal = $iVal;
   	}
    	
	$iDebugVal ++;
	DebugVal($iDebugVal);
}

function _getDebugPath($strSection)
{
    $strPath = _checkDebugPath(); 
    $strPath .= '/'.$strSection;
    if (is_dir($strPath) == false)  mkdir($strPath);
    
    return $strPath;
}

function DebugGetImageName($str)
{
    $strPath = _getDebugPath('image');
    return "$strPath/$str.jpg";
}

function DebugGetCsvName($str)
{
    $strPath = _getDebugPath('csv');
    return "$strPath/$str.csv";
}

function DebugGetFontName($str)
{
    $strPath = _getDebugPath('font');
    return "$strPath/$str.ttf";
}

function DebugGetChinaMoneyFile()
{
    $strPath = _getDebugPath('chinamoney');
    return "$strPath/json.txt";
}

function _getDebugFileName($strSection, $strSymbol)
{
    $strPath = _getDebugPath($strSection);
    
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
    return _getDebugFileName('sina', $strSymbol);
}

function DebugGetEastMoneyFileName($strSymbol)
{
    return _getDebugFileName('eastmoney', $strSymbol);
}

function DebugGetYahooWebFileName($strSymbol)
{
    return _getDebugFileName('yahooweb', $strSymbol);
}

function DebugGetYahooHistoryFileName($strSymbol)
{
    return _getDebugFileName('yahoohistory', $strSymbol);
}

function DebugGetConfigFileName($strSymbol)
{
    return _getDebugFileName('config', $strSymbol);
}

function unlinkConfigFile($strSymbol)
{
	unlinkEmptyFile(DebugGetConfigFileName($strSymbol));
}
?>
