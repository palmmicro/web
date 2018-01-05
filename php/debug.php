<?php
require_once('url.php');

define ('DEBUG_UTF8_BOM', "\xef\xbb\xbf");

define ('DEBUG_FILE_PATH', 'debug');
define ('DEBUG_FILE_NAME', 'debug.txt');
define ('DEBUG_TEST_PATHNAME', 'php/test.php');

define ('DEBUG_TIME_ZONE', 'PRC');
define ('DEBUG_TIME_FORMAT', 'Y-m-d H:i:s');
define ('DEBUG_DATE_FORMAT', 'Y-m-d');

define ('SECONDS_IN_MIN', 60);
define ('SECONDS_IN_HOUR', 3600);
define ('SECONDS_IN_DAY', 86400);

function unlinkEmptyFile($strFileName)
{
    if (!unlink($strFileName))
    {
        file_put_contents($strFileName, '');
    }
}

function _getTimeDisplay($iTime, $strTimeZone)
{
    date_default_timezone_set($strTimeZone);
    return date(DEBUG_TIME_FORMAT, $iTime);
}

function explodeDateTime($iTime, $strTimeZone)
{
    return explode(' ', _getTimeDisplay($iTime, $strTimeZone)); 
}

function explodeDebugDateTime()
{
    return explodeDateTime(time(), DEBUG_TIME_ZONE);
}

function _getTimeDisplayPRC($iTime)
{
    return _getTimeDisplay($iTime, DEBUG_TIME_ZONE);
}

function DebugGetTimeDisplay()
{
    return _getTimeDisplayPRC(time());
}

function DebugGetStopWatchDisplay($fStop, $fStart)
{
    return ' ('.strval(round($fStop - $fStart, 2)).'s)';
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
    $strTimeZone = date_default_timezone_get();
    file_put_contents(DebugGetFile(), DebugGetTimeDisplay().': '.$str.PHP_EOL, FILE_APPEND);     // DebugGetTimeDisplay will change timezone!
    date_default_timezone_set($strTimeZone);
}

function DebugVal($iVal)
{
    DebugString(strval($iVal)); 
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

function DebugGetGoogleFileName($strSymbol)
{
    return _getDebugFileName('google', $strSymbol);
}

function DebugGetGoogleHistoryFileName($strSymbol)
{
    return _getDebugFileName('googlehistory', $strSymbol);
}

function DebugGetEastMoneyFileName($strSymbol)
{
    return _getDebugFileName('eastmoney', $strSymbol);
}

function DebugGetYahooFileName($strSymbol)
{
    return _getDebugFileName('yahoo', $strSymbol);
}

function DebugGetYahooHistoryFileName($strSymbol)
{
    return _getDebugFileName('yahoohistory', $strSymbol);
}

function DebugGetConfigFileName($strSymbol)
{
    return _getDebugFileName('config', $strSymbol);
}

function DebugGetExternalLink($strHttp, $strDisplay)
{
    $strLink = "<a href=\"$strHttp\" target=_blank>$strDisplay</a>";
    return $strLink;
}

function DebugGetLink($strHttp)
{
    return DebugGetExternalLink($strHttp, $strHttp);
}

function _getFileTimeDisplay($strPathName)
{
    clearstatcache(true, $strPathName);
    if (file_exists($strPathName))
    {
        return _getTimeDisplayPRC(filemtime($strPathName));
    }
    return '';
}

function DebugFileLink($strPathName)
{
    return DebugGetExternalLink(UrlGetServer().$strPathName, UrlGetFileName($strPathName));
}

function DebugGetFileLink($strPathName)
{
    $strLink = DebugFileLink($strPathName);
    $strLastTime = _getFileTimeDisplay($strPathName);
    $strDelete = UrlGetDeleteLink('/php/_submitdeletefile.php?delete='.$strPathName, '调试文件', 'debug file', false);
    return "$strLink($strLastTime $strDelete)";
}

function DebugGetDebugFileLink()
{
    return DebugGetFileLink(DebugGetFile()).' '.DebugGetFileLink(UrlGetRootDir().DEBUG_TEST_PATHNAME);
}

?>
