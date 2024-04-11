<?php
define('URL_PHP', '.php');
define('URL_CNPHP', 'cn.php');

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

function UrlGetRefererHeader($strReferer)
{
	return array('Referer: '.$strReferer);
}

function url_get_contents($strUrl, $arExtraHeaders = false, $strFileName = false)
{
	global $acct;
	if (method_exists($acct, 'AllowCurl'))
	{
		if ($acct->AllowCurl() == false)		return false;
	}
	
    $ch = curl_init();  
    $timeout = 2;  
    curl_setopt($ch, CURLOPT_URL, $strUrl);
    
	$arHeaders = array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
//							'x-test: true',
//							'x-test2: true',
//							'stream: True'
							);
    
    if ($arExtraHeaders)	
    {
    	$arHeaders = array_merge($arHeaders, $arExtraHeaders);
//    	DebugPrint($arHeaders);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeaders);
    
//    if ($strReferer)	curl_setopt($ch, CURLOPT_REFERER, $strReferer);
//	if ($strCookie)	curl_setopt($ch, CURLOPT_COOKIE, $strCookie);

//    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');						// Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (str_starts_with($strUrl, 'https'))
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    	
    if (($img = curl_exec($ch)) == false)
    {
    	DebugString($strUrl.'读取错误：'.curl_error($ch));
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

function UrlModifyRootFileName($strFileName)
{
	if (str_starts_with($strFileName, '/'))		return	UrlGetRootDir().substr($strFileName, 1);
	return $strFileName;
}

function UrlGetPathName($strPathName)
{
	return '/'.substr($strPathName, strlen(UrlGetRootDir()));
}

// Function to sanitize values received from the form. Prevents SQL injection
function UrlCleanString($str) 
{
	$str = @trim($str);
//	if (get_magic_quotes_gpc()) 
//	{
		$str = stripslashes($str);
//	}
	return $str;
}

// accessToken=eyJhbGciOiJIUzI1NiIsImtpZCI6ImRlZmF1bHQiLCJ0eXAiOiJKV1QifQ.eyJhdWQiOiJhY2Nlc3NfcmVzb3VyY2UiLCJleHAiOjE2NDAyMzcwOTQsImciOiJ3WVJUOGs5NmQzcnhydHd4IiwiaWF0IjoxNjQwMjM2Nzk0LCJ1c2VySWQiOi0xNDYwMzcwMTA2fQ.OcQAZ-1xdFtBu6XOZmh5OwXbHw1jFITdbdw8shqlRIE
// continueFlag=24dc682e3f5892a79193842f97156bc8
// from=groupmessage&isappinstalled=0&scene=1&clicktime=1579733595&enterid=1579733595
// tdsourcetag=s_pcqq_aiomsg
// xueqiu_status_id=140805627&xueqiu_status_from_source=sstl&xueqiu_status_source=statusdetail&xueqiu_private_from_source=0105&key_name=0106
// xueqiu_comment_id=226049545&xueqiu_status_id=210729879&comment_from=comment_detail_page&key_name=011701
// entryScene=zhida_05_001&jump_from=1_13_18_00
// fbclid=IwAR0fSj2-McWUF2fs80iiuVaKisnq9fbiicNmxZFJ8Z4BeD6EOQHc6EQGjwk
// share_token=9E9C328B-D19C-4188-AF1A-4FAD05D42D35&tt_from=weixin&wxshare_count=1
// ivk_sa=1024320u
function UrlGetQueryString()
{ 
	if (isset($_SERVER['QUERY_STRING']))
	{
		$str = '';
		$ar = explode('&', UrlCleanString($_SERVER['QUERY_STRING']));
		foreach ($ar as $strQuery)
		{
			if ((strpos($strQuery, 'accessToken=') === false) 
				&& (strpos($strQuery, 'clicktime=') === false)
				&& (strpos($strQuery, 'comment_from=') === false)
				&& (strpos($strQuery, 'continueFlag=') === false)
				&& (strpos($strQuery, 'enterid=') === false)
				&& (strpos($strQuery, 'entryScene=') === false)
				&& (strpos($strQuery, 'fbclid=') === false)
				&& (strpos($strQuery, 'from=') === false)
				&& (strpos($strQuery, 'ivk_sa=') === false)
				&& (strpos($strQuery, 'isappinstalled=') === false)
				&& (strpos($strQuery, 'jump_from=') === false)
				&& (strpos($strQuery, 'key_name=') === false)
				&& (strpos($strQuery, 'load_id=') === false)
				&& (strpos($strQuery, 'scene=') === false)
				&& (strpos($strQuery, 'share_token=') === false)
				&& (strpos($strQuery, 'tdsourcetag=') === false)
				&& (strpos($strQuery, 'tt_from=') === false)
				&& (strpos($strQuery, 'wxshare_count=') === false)
				&& (strpos($strQuery, 'xueqiu_comment_id=') === false)
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
   	if (str_starts_with($str, '//'))			return false;
   	if (strpos($str, '..') !== false)		return false;
   	if (stripos($str, URL_PHP) === false)	return false;
   	return true;
}

// /woody/blog/entertainment/20140615cn.php
function UrlGetUri()
{ 
	$str = UrlGetCur();
   	if (UrlIsValid($str) == false)	die('Unknown URI: '.UrlGetServer().$str);
   	
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
   	if (str_ends_with($str, 'cn'))
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
   	
   	// https://www.palmmicro.com/woody/res/sz12411 ==> sz12411
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
    $str = ($strQuery = UrlGetQueryString()) ? md5($strQuery) : ''; 
	return UrlGetPage().$str;
}

?>
