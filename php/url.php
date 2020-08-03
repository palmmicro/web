<?php
define('URL_PHP', '.php');
define('URL_CNPHP', 'cn.php');

define('NAV_DIR_FIRST', 'First');
define('NAV_DIR_PREV', 'Prev');
define('NAV_DIR_NEXT', 'Next');
define('NAV_DIR_LAST', 'Last');

function UrlGetNavDisplayArray()
{
    return array(NAV_DIR_FIRST => '第一页', NAV_DIR_PREV => '上一页', NAV_DIR_NEXT => '下一页', NAV_DIR_LAST => '最后一页');
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

function url_get_contents($strUrl, $strCookie = false)
{
	global $acct;
	if ($acct->AllowCurl() == false)		return false;
	
	$strFileName = DebugGetPathName('debugcurl.txt');
    if (file_exists($strFileName))
    {
    	if (time() - filemtime($strFileName) < 30)
    	{
//    		DebugString('Ignored: '.$strUrl);
    		return false;
    	}
    }
    
    $ch = curl_init();  
    $timeout = 2;  
    curl_setopt($ch, CURLOPT_URL, $strUrl);  
    if ($strCookie)
    {
    	curl_setopt($ch, CURLOPT_COOKIE, $strCookie);  
    }
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (substr($strUrl, 0, 5) == 'https')
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    	
    $img = curl_exec($ch);
    if ($img == false)
    {
    	DebugString($strUrl.' '.curl_error($ch));
    	file_put_contents($strFileName, $strUrl);
    }
    curl_close($ch);
    return $img;
}

function UrlGetServer()
{
    $strServer = 'http';
    if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || $_SERVER['SERVER_PORT'] == 443)
    {
		$strServer .= 's';
    }
    $strServer .= '://';
/*    if ($_SERVER['SERVER_PORT'] != '80')    
    {
        $strServer .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
    }
    else
    {*/
        $strServer .= $_SERVER['SERVER_NAME'];
//    }
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

// Function to sanitize values received from the form. Prevents SQL injection
function UrlCleanString($str) 
{
	$str = @trim($str);
	if (get_magic_quotes_gpc()) 
	{
		$str = stripslashes($str);
	}
	return $str;
}

function UrlGetQueryString()
{ 
	if (isset($_SERVER['QUERY_STRING']))	    return UrlCleanString($_SERVER['QUERY_STRING']);
	return false;
}

function UrlGetQueryValue($strQueryItem)
{ 
	$query = $_GET;
	if (isset($query[$strQueryItem]))
	{
		$str = $query[$strQueryItem];
		$str = str_replace('=', '', $str);
	    return UrlCleanString($str);
	}
	return false;
}

function UrlGetQueryDisplay($strQueryItem, $strDefault = '')
{ 
    if (($str = UrlGetQueryValue($strQueryItem)) !== false)
    {
        return $str;
    }
    return $strDefault;
}

function UrlGetQueryInt($strQueryItem, $iDefault = 0)
{ 
    if (($strNum = UrlGetQueryValue($strQueryItem)) !== false)
    {
        return intval($strNum);
    }
    return $iDefault;
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

function UrlAddQuery($strAdd)
{
    if ($strQuery = UrlGetQueryString())
    {
    	return $strQuery.'&'.$strAdd;
    }
    return $strAdd;
}

function filter_valid_ip($strIp)
{
	if ($strIp)
	{
		return filter_var($strIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE);
	}
	return false;
}

function UrlGetCur()
{ 
	return $_SERVER['REQUEST_URI'];
}

function UrlIsValid($str)
{
   	if (substr($str, 0, 2) == '//')			return false;
   	if (strpos($str, '..') !== false)		return false;
   	if (stripos($str, URL_PHP) === false)	return false;
   	return true;
}

// /woody/blog/entertainment/20140615cn.php
function UrlGetUri()
{ 
	$str = UrlGetCur();
   	if (UrlIsValid($str) == false)
   	{
   		dieDebugString('Unknown URI: '.UrlGetServer().$str);
   	}
   	
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
//    if (strstr($_SERVER["SCRIPT_NAME"], URL_CNPHP) == URL_CNPHP)
    $str = UrlGetUri();
    if (strstr($str, URL_CNPHP) == URL_CNPHP)
    {
        return URL_CNPHP;
    }
    else if (strstr($str, URL_PHP) == URL_PHP)
    {
        return URL_PHP;
    }
    else if (_cnEndString($str))
    {
        return URL_CNPHP;
    }
    return URL_PHP;
}

// /woody/blog/entertainment/20140615cn.php ==> 20140615
function _getTitle($str)
{
    $strType = UrlGetType();
   	$iPos = stripos($str, $strType);
   	if ($iPos > 0)
   	{
   	    return substr($str, 0, $iPos);
   	}
   	
   	// http://www.palmmicro.com/woody/res/snp ==> snp
//   	DebugString($str);
    if (_cnEndString($str))
   	{
   	    return substr($str, 0, strlen($str) - 2);
   	}
   	return $str;
}

// /woody/blog/entertainment/20140615cn.php ==> 20140615cn.php
function UrlGetFileName($strPathName)
{
    return substr($strPathName, strrpos($strPathName, "/") + 1);
}

function UrlGetTitle()
{
    $str = UrlGetUri();
    return _getTitle(UrlGetFileName($str));
}

function UrlGetUriTitle()
{
    return _getTitle(UrlGetUri());
}

function UrlGetPhp($bChinese = true)
{
    return $bChinese ? URL_CNPHP : URL_PHP;
}

function UrlGetHtml($bChinese = true)
{
    return $bChinese ? 'cn.html' : '.html';
}

function UrlGetDomain()
{
	$strDomain = $_SERVER['SERVER_NAME'];
	if (stripos($strDomain, 'www.') !== false)
	{
		$strDomain = substr($strDomain, 4);
	}
	return strtolower($strDomain);
}

function UrlIsPalmmicroDomain()
{
    return (UrlGetDomain() == 'palmmicro.com') ? true : false;
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

function UrlGetUniqueString()
{
	$str = '';
    if ($strQuery = UrlGetQueryString())
    {
    	$ar = explode('&', $strQuery);
    	foreach ($ar as $strItem)
    	{
    		$str .= str_replace('=', '', $strItem);
    	}
    }
	$str = str_replace('%', '', $str);
    if (strlen($str) > 32)	$str = md5($str); 
	return UrlGetTitle().$str;
}

?>
