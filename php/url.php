<?php
define('URL_PHP', '.php');
define('URL_CNPHP', 'cn.php');

define('MENU_DIR_FIRST', 'First');
define('MENU_DIR_PREV', 'Prev');
define('MENU_DIR_NEXT', 'Next');
define('MENU_DIR_LAST', 'Last');

function UrlGetMenuArray()
{
    return array(MENU_DIR_FIRST => '第一页', MENU_DIR_PREV => '上一页', MENU_DIR_NEXT => '下一页', MENU_DIR_LAST => '最后一页');
}

function filter_valid_ip($strIp)
{
	if ($strIp)
	{
		return filter_var($strIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE);
	}
	return false;
}

function UrlGetIp()
{ 
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
	    $strIp = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
	    if (filter_valid_ip($strIp))    return $strIp;
	}
	else if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
	    $strIp = trim($_SERVER['HTTP_CLIENT_IP']);
	    if (filter_valid_ip($strIp))    return $strIp;
	}
	else
	{
		$strIp = trim($_SERVER['REMOTE_ADDR']);
	    if (filter_valid_ip($strIp))    return $strIp;
	}
	die('Unknown IP');
	return false;
}

function url_get_contents($strUrl, $strCookie = false, $strReferer = false, $strFileName = false)
{
	global $acct;
	if (method_exists($acct, 'AllowCurl'))
	{
		if ($acct->AllowCurl() == false)		return false;
	}
	
    $ch = curl_init();  
    $timeout = 2;  
    curl_setopt($ch, CURLOPT_URL, $strUrl);
	if ($strReferer)	curl_setopt($ch, CURLOPT_REFERER, $strReferer);
	if ($strCookie)	curl_setopt($ch, CURLOPT_COOKIE, $strCookie);  
//    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');						// Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (substr($strUrl, 0, 5) == 'https')
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    	
    if (($img = curl_exec($ch)) == false)
    {
    	DebugString($strUrl.' '.curl_error($ch));
    	if ($strFileName)		file_put_contents($strFileName, $strUrl);
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

// accessToken=eyJhbGciOiJIUzI1NiIsImtpZCI6ImRlZmF1bHQiLCJ0eXAiOiJKV1QifQ.eyJhdWQiOiJhY2Nlc3NfcmVzb3VyY2UiLCJleHAiOjE2NDAyMzcwOTQsImciOiJ3WVJUOGs5NmQzcnhydHd4IiwiaWF0IjoxNjQwMjM2Nzk0LCJ1c2VySWQiOi0xNDYwMzcwMTA2fQ.OcQAZ-1xdFtBu6XOZmh5OwXbHw1jFITdbdw8shqlRIE
// continueFlag=24dc682e3f5892a79193842f97156bc8
// from=singlemessage
// from=groupmessage&isappinstalled=0
// tdsourcetag=s_pcqq_aiomsg
// xueqiu_status_id=74414796&xueqiu_status_source=rptl
// xueqiu_status_id=64054510&xueqiu_status_from_source=sstl&xueqiu_status_source=statusdetail&xueqiu_private_from_source=0105
// xueqiu_status_id=140805627&xueqiu_status_from_source=sstl&xueqiu_status_source=statusdetail&xueqiu_private_from_source=0105&key_name=0106
function UrlGetQueryString()
{ 
	if (isset($_SERVER['QUERY_STRING']))
	{
		$str = '';
		$ar = explode('&', UrlCleanString($_SERVER['QUERY_STRING']));
		foreach ($ar as $strQuery)
		{
			if ((strpos($strQuery, 'accessToken=') === false) 
				&& (strpos($strQuery, 'continueFlag=') === false)
				&& (strpos($strQuery, 'from=') === false)
				&& (strpos($strQuery, 'isappinstalled=') === false)
				&& (strpos($strQuery, 'key_name=') === false)
				&& (strpos($strQuery, 'tdsourcetag=') === false)
				&& (strpos($strQuery, 'xueqiu_private_from_source=') === false)
				&& (strpos($strQuery, 'xueqiu_status_from_source=') === false)
				&& (strpos($strQuery, 'xueqiu_status_id=') === false)
				&& (strpos($strQuery, 'xueqiu_status_source=') === false)
				)
			{
				$str .= $strQuery.'&';
			}
		}
		if ($str != '')	return rtrim($str, '&');
	}
	return false;
}

function UrlAddQuery($strAdd)
{
    if ($strQuery = UrlGetQueryString())
    {
    	return $strQuery.'&'.$strAdd;
    }
    return $strAdd;
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
function _getPage($str)
{
    $strType = UrlGetType();
   	$iPos = stripos($str, $strType);
   	if ($iPos > 0)
   	{
   	    return substr($str, 0, $iPos);
   	}
   	
   	// https://www.palmmicro.com/woody/res/snp ==> snp
//   	DebugString($str);
    if (_cnEndString($str))
   	{
   	    return substr($str, 0, strlen($str) - 2);
   	}
   	return $str;
}

function UrlGetPage()
{
    return _getPage(basename(UrlGetUri()));
}

function UrlGetUriPage()
{
    return _getPage(UrlGetUri());
}

function UrlGetPhp($bChinese = true)
{
    return $bChinese ? URL_CNPHP : URL_PHP;
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
	return UrlGetPage().$str;
}

?>
