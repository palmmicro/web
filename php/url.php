<?php
define('URL_HTML', '.html');
define('URL_CNHTML', 'cn.html');

define('URL_PHP', '.php');
define('URL_CNPHP', 'cn.php');

define('URL_WWW', 'www.');

function url_get_contents($strUrl)
{
    $ch = curl_init();  
    $timeout = 3;  
    curl_setopt($ch, CURLOPT_URL, $strUrl);  
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (substr($strUrl, 0, 5) == 'https')
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    $img = curl_exec($ch);  
    curl_close($ch);
    return $img;
}

function UrlGetServer()
{
    $strServer = 'http';
    if ($_SERVER['HTTPS'] == 'on')
    {
        $strServer .= 's';
    }
    $strServer .= '://';
    if ($_SERVER['SERVER_PORT'] != '80')    
    {
        $strServer .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
    }
    else
    {
        $strServer .= $_SERVER['SERVER_NAME'];
    }
    return $strServer;
}

function UrlGetRootDir()
{
    $strRoot = $_SERVER['DOCUMENT_ROOT'];
    if ($strRoot != '/')
    {
        $strRoot .= '/';
    }
    return $strRoot;
}

function UrlGetQueryString()
{ 
	if (isset($_SERVER['QUERY_STRING']))	    return $_SERVER['QUERY_STRING'];
	return false;
}

function UrlGetQueryValue($strQueryItem)
{ 
/*	if ($strQuery = UrlGetQueryString())
	{
	    if (strstr($strQuery, '=', true) == $strQueryItem)
	    {
	        $strEqual = strstr($strQuery, '=');
	        return substr($strEqual, 1);
	    }
	}*/
	$query = $_GET;
	if (isset($query[$strQueryItem]))    return $query[$strQueryItem]; 
	return false;
}

function UrlGetQueryInt($strQueryItem, $iDefault)
{ 
    $iNum = $iDefault;
    if ($strNum = UrlGetQueryValue($strQueryItem))
    {
        $iNum = intval($strNum);
    }
    return $iNum;
}

function UrlPassQuery()
{
	if ($strQuery = UrlGetQueryString())
	{
	    $strPassQuery = '?'.$strQuery;
	}
	else
	{
	    $strPassQuery = '';
	}
	return $strPassQuery;
}

function filter_valid_ip($strIp)
{
    return filter_var($strIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE);
}

function UrlGetIp()
{ 
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
	    $strIp = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
	    if (filter_valid_ip($strIp))    return $strIp;
	}
	
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
	    $strIp = trim($_SERVER['HTTP_CLIENT_IP']);
	    if (filter_valid_ip($strIp))    return $strIp;
	}
 
	return trim($_SERVER['REMOTE_ADDR']);
}

// /woody/blog/entertainment/20140615cn.php
function UrlGetUri()
{ 
	$str = $_SERVER['REQUEST_URI'];
	if ($iPos = strpos($str, '.'))
	{
	    if (substr($str, $iPos, 4) == URL_PHP)
	    {
	        $str = substr($str, 0, $iPos + 4);
	    }
	}
/*	if ($iPos = strpos($str, '?'))
	{
	    $str = substr($str, 0, $iPos);
	}
*/	
	return $str;
}

// http://www.palmmicro.com/woody/blog/entertainment/20140615cn.php
function UrlGetCur()
{
    $strUrl = UrlGetServer();
    $strUrl .= UrlGetUri();
    return $strUrl;
}

function _cnEndString($str)
{
   	if (substr($str, -2, 2) == 'cn')
   	{
   	    return true;
   	}
   	return false;
}

// /woody/blog/entertainment/20140615cn.php ==> cn.php
function UrlGetType()
{
//    if (strchr($_SERVER["SCRIPT_NAME"], URL_CNPHP) == URL_CNPHP)
    $str = UrlGetUri();
    if (strchr($str, URL_CNPHP) == URL_CNPHP)
    {
        return URL_CNPHP;
    }
    else if (strchr($str, URL_PHP) == URL_PHP)
    {
        return URL_PHP;
    }
    else if (_cnEndString($str))
    {
        return URL_CNPHP;
    }
    return URL_PHP;
}

function UrlGetFileName($strPathName)
{
    return substr($strPathName, strrpos($strPathName, "/") + 1);
}

// /woody/blog/entertainment/20140615cn.php ==> 20140615cn.php
function UrlGetPageName() 
{
//    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
    $str = UrlGetUri();
    return UrlGetFileName($str);
}

// /woody/blog/entertainment/20140615cn.php ==> 20140615
function UrlGetTitle()
{
    $str = UrlGetPageName();
    $strType = UrlGetType();
   	$iPos = strpos($str, $strType);
   	if ($iPos > 0)
   	{
   	    return substr($str, 0, $iPos);
   	}
   	
   	// http://www.palmmicro.com/woody/res/futurecl ==> futurecl
//   	DebugString($str);
    if (_cnEndString($str))
   	{
   	    return substr($str, 0, strlen($str) - 2);
   	}
   	return $str;
}

function UrlGetPhp($bChinese)
{
    return $bChinese ? URL_CNPHP : URL_PHP;
}

// /woody/blog/entertainment/20140615cn.php ==> 20140615.php
function UrlSwitchLanguage()
{
    $strCur = UrlGetTitle();
    $strCur .= UrlGetPhp(UrlIsEnglish());
    return $strCur.UrlPassQuery();
}

function UrlGetDomain()
{
	$strDomain = $_SERVER['SERVER_NAME'];
	if (strchr($strDomain, URL_WWW))
	{
		return substr($strDomain, 4);
	}
	return strtolower($strDomain);
}

function UrlGetEmail($strName)
{
	$strEmail = $strName.'@';
	$strEmail .= UrlGetDomain();
	return $strEmail;
}

function UrlIsChinese()
{
    return (UrlGetType() == URL_CNPHP) ? true : false;
}

function UrlIsEnglish()
{
    return (UrlGetType() == URL_PHP) ? true : false;
}

function UrlBuildPhpLink($strPathTitle, $strQuery, $strCn, $strUs, $bChinese)
{
    $strDisplay = $bChinese ? $strCn : $strUs;
    return UrlGetPhpLink($strPathTitle, $strQuery, $strDisplay, $bChinese);
}

function UrlGetPhpLink($strPathTitle, $strQuery, $strDisplay, $bChinese)
{
    $str = $strPathTitle;
    $str .= UrlGetPhp($bChinese);
    if ($strQuery)
    {
        if (substr($strQuery, 0, 1) == '#')
        {
            $str .= $strQuery;
        }
        else
        {
            $str .= '?'.$strQuery;
        }
    }
    return UrlGetLink($str, $strDisplay);
}

function UrlGetCategoryLinks($strPath, $arCategory, $bChinese)
{
    $str = '';
    foreach ($arCategory as $strCategory => $strDisplay)
    {
        if ($strCategory != UrlGetTitle())
        {
            $str .= UrlGetPhpLink($strPath.$strCategory, false, $strDisplay, $bChinese).' ';
        }
    }
    return $str;
}

function UrlGetLink($strPath, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\">$strDisplay</a>";
    return $strLink;
}

function UrlGetOnClickLink($strPath, $strQuestion, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\" onclick=\"return confirm('$strQuestion')\">$strDisplay</a>";
    return $strLink;
}

function UrlGetEditLink($strPathTitle, $strEdit, $bChinese)
{
    return UrlBuildPhpLink($strPathTitle, 'edit='.$strEdit, '修改', 'Edit', $bChinese);
}

function UrlGetDeleteLink($strPath, $strCn, $strUs, $bChinese)
{
    if ($bChinese)
    {
        $strDisplay = '删除';
        $strQuestion = '确认删除'.$strCn;
    }
    else
    {
        $strDisplay = 'Delete';
        $strQuestion = 'Confirm delete '.$strUs;
    }
    return UrlGetOnClickLink($strPath, $strQuestion.'?', $strDisplay);
}

define ('DEFAULT_NAV_DISPLAY', 100);

define ('NAV_DIR_FIRST', 'First');
define ('NAV_DIR_PREV', 'Prev');
define ('NAV_DIR_NEXT', 'Next');
define ('NAV_DIR_LAST', 'Last');

function UrlGetNavDisplayArray()
{
    return array(NAV_DIR_FIRST => '第一页', NAV_DIR_PREV => '上一页', NAV_DIR_NEXT => '下一页', NAV_DIR_LAST => '最后一页');
}

function _getNavLinkQuery($strId, $iStart, $iNum)
{
    $str = '';
    if ($strId)
    {
        $str = $strId.'&';
    }
    $str .= 'start='.strval($iStart).'&num='.strval($iNum);
    return $str;
}

function UrlGetNavLink($strPath, $strQueryId, $iTotal, $iStart, $iNum, $bChinese)
{
    $arDir = UrlGetNavDisplayArray();
    
    $str = ($bChinese ? '总数' : 'Total').': '.strval($iTotal).' ';
    $iLast = $iStart + $iNum;
    if ($iLast > $iTotal)   $iLast = $iTotal;
    if ($iTotal > 0)
    {
        $str .= ($bChinese ? '当前显示' : 'Current').': '.strval($iStart).'-'.strval($iLast - 1).' ';
    }
    
    if ($iStart > 0)
    {   // Prev
        if ($iStart > $iNum)
        {
            $iPrevStart = $iStart - $iNum;
        }
        else
        {
            $iPrevStart = 0;
        }
        
        if ($iPrevStart != 0)
        {   // First
            $strQuery = _getNavLinkQuery($strQueryId, 0, $iNum);
            $str .= UrlBuildPhpLink($strPath, $strQuery, $arDir[NAV_DIR_FIRST], NAV_DIR_FIRST, $bChinese).' ';
        }
        $strQuery = _getNavLinkQuery($strQueryId, $iPrevStart, $iNum);
        $str .= UrlBuildPhpLink($strPath, $strQuery, $arDir[NAV_DIR_PREV], NAV_DIR_PREV, $bChinese).' ';
    }
    
    $iNextStart = $iStart + $iNum;
    if ($iNextStart < $iTotal)
    {   // Next
        $strQuery = _getNavLinkQuery($strQueryId, $iNextStart, $iNum);
        $str .= UrlBuildPhpLink($strPath, $strQuery, $arDir[NAV_DIR_NEXT], NAV_DIR_NEXT, $bChinese).' ';
        if ($iNextStart + $iNum < $iTotal)
        {   // Last
            $strQuery = _getNavLinkQuery($strQueryId, $iTotal - $iNum, $iNum);
            $str .= UrlBuildPhpLink($strPath, $strQuery, $arDir[NAV_DIR_LAST], NAV_DIR_LAST, $bChinese);
        }
    }
    return $str;
}

?>
