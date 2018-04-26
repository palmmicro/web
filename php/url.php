<?php
define('URL_HTML', '.html');
define('URL_CNHTML', 'cn.html');

define('URL_PHP', '.php');
define('URL_CNPHP', 'cn.php');

define('URL_WWW', 'www.');

define('NAV_DIR_FIRST', 'First');
define('NAV_DIR_PREV', 'Prev');
define('NAV_DIR_NEXT', 'Next');
define('NAV_DIR_LAST', 'Last');

function UrlGetNavDisplayArray()
{
    return array(NAV_DIR_FIRST => '第一页', NAV_DIR_PREV => '上一页', NAV_DIR_NEXT => '下一页', NAV_DIR_LAST => '最后一页');
}

function url_get_contents($strUrl)
{
    $ch = curl_init();  
    $timeout = 2;  
    curl_setopt($ch, CURLOPT_URL, $strUrl);  
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (substr($strUrl, 0, 5) == 'https')
    {
//    	DebugString('https: '.$strUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    $img = curl_exec($ch);
    if ($img == false)
    {
    	DebugString('url_get_contents:'.$strUrl.curl_error($ch));
    }
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

// Function to sanitize values received from the form. Prevents SQL injection
function UrlCleanString($str) 
{
	$str = @trim($str);
	if (get_magic_quotes_gpc()) 
	{
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

function UrlGetQueryValue($strQueryItem)
{ 
	$query = $_GET;
	if (isset($query[$strQueryItem]))
	{
	    return UrlCleanString($query[$strQueryItem]);
	}
	return false;
}

function UrlGetQueryDisplay($strQueryItem, $strDefault)
{ 
    if ($str = UrlGetQueryValue($strQueryItem))
    {
        return $str;
    }
    return $strDefault;
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
    $strUrl .= UrlPassQuery();
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
function _getTitle($str)
{
    $strType = UrlGetType();
   	$iPos = strpos($str, $strType);
   	if ($iPos > 0)
   	{
   	    return substr($str, 0, $iPos);
   	}
   	
   	// http://www.palmmicro.com/woody/res/cl ==> cl
//   	DebugString($str);
    if (_cnEndString($str))
   	{
   	    return substr($str, 0, strlen($str) - 2);
   	}
   	return $str;
}

function UrlGetTitle()
{
    return _getTitle(UrlGetPageName());
}

function UrlGetUriTitle()
{
    return _getTitle(UrlGetUri());
}

function UrlGetPhp($bChinese)
{
    return $bChinese ? URL_CNPHP : URL_PHP;
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

?>
