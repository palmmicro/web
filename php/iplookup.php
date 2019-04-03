<?php
//require_once('url.php');
require_once('debug.php');
require_once('ui/commentparagraph.php');

define('TAOBAO_IP_URL', 'http://ip.taobao.com/service/getIpInfo.php?ip=');
function _getTaobaoIpLookUpUrl($strIp)
{
    return TAOBAO_IP_URL.$strIp;
}

function TaobaoIpLookUp($strIp)
{
    $strUrl = _getTaobaoIpLookUpUrl($strIp);
    $str = url_get_contents($strUrl); 
    $json = json_decode($str);
    if ((string)$json->code == '1')
    {
        return array('country' => '', 'area' => '', 'region' => '', 'city' => '', 'isp' => '');
    }
    return (array)$json->data;    
}

define('IPINFO_IO_IP_URL', 'http://ipinfo.io/');
function _getIpInfoIpLookUpUrl($strIp)
{
    return IPINFO_IO_IP_URL.$strIp.'/json';
}

function IpInfoIpLookUp($strIp)
{ 
    $strUrl = _getIpInfoIpLookUpUrl($strIp); 
    $str = url_get_contents($strUrl);
    $ar = json_decode($str, true);
    if ($ar['hostname'] == 'No Hostname')  $ar['hostname'] = '';
    return $ar;
}

// http://www.projecthoneypot.org/httpbl_api.php
define('PROJECT_HONEY_POT_URL', 'http://www.projecthoneypot.org/ip_');
function ProjectHoneyPotGetSearchEngineArray()
{
    return array('Undocumented', 'AltaVista', 'Ask', 'Baidu', 'Excite', 'Google', 'Looksmart', 'Lycos', 'MSN', 'Yahoo', 'Cuil', 'InfoSeek', 'Miscellaneous', '(13)', 'Yandex');
}

define('PROJECT_HONEY_POT_KEY', 'qvcumkhjlcik');
define('HTTPBL_ORG_URL', '.dnsbl.httpbl.org');
function ProjectHoneyPotIpLookUp($strIp)
{
    $ar = explode('.', $strIp);
    $strDns = PROJECT_HONEY_POT_KEY.'.'.$ar[3].'.'.$ar[2].'.'.$ar[1].'.'.$ar[0].HTTPBL_ORG_URL;
    $str = gethostbyname($strDns);
    if ($str != $strDns)
    {
        $ar = explode('.', $str);
        if ($ar[0] == '127')
        {
            return $ar;
        }
    }
    return false;
}

function ProjectHoneyPotCheckSearchEngine($strIp)
{
    if ($ar = ProjectHoneyPotIpLookUp($strIp))
    {
        if ($ar[3] == '0')
        {
            $arSearchEngine = ProjectHoneyPotGetSearchEngineArray();
            $iIndex = intval($ar[2]);
            AcctEmailSpiderReport($strIp, 'Known ProjectHoneyPot Search Engine - '.$arSearchEngine[$iIndex], 'Known spider');
            return true;
        }
    }
    return false;
}

function _getProjectHoneyPotIpLookUpString($ar)
{
    if ($ar[3] == '0')
    {
        $arSearchEngine = ProjectHoneyPotGetSearchEngineArray();
        $iIndex = intval($ar[2]);
        return 'Search Engine - '.$arSearchEngine[$iIndex].'('.$ar[2].')';
    }
    
    $iVal = intval($ar[3]);
    $str = '';
    if ($iVal & 1)          $str .= 'Suspicious,';
    else if ($iVal & 2)     $str .= 'Harvester,';
    else if ($iVal & 4)     $str .= 'Comment Spammer,';
    
    $str .= 'Threat score: '.$ar[2].'. Last seen: '.$ar[1].' days ago';
    return $str;
}

function DnsIpLookUp($strIp)
{
    $strHostName = gethostbyaddr($strIp);
    if ($strHostName)
    {
        if ($strHostName != $strIp)
        {
            return $strHostName;
        }
    }
    return false;
}

// http://unitymediagroup.de/
// yandex.com
function DnsCheckSearchEngine($strIp)
{
    if ($str = DnsIpLookUp($strIp))
    {
        $str = strtolower($str);
        if (strstr($str, 'googlebot.com') || strstr($str, 'google.com') || strstr($str, 'crawl.baidu.com') || strstr($str, 'yandex') || strstr($str, 'search.msn.com') || strstr($str, 'crawl.sogou.com')
            || strstr($str, 'yse.yahoo.net')
            )
        {
            AcctEmailSpiderReport($strIp, 'Known DNS: '.$str, 'Known spider');
            return true;
        }
    }
    return false;
}

function _ipLookupMemberTable($strIp, $strNewLine, $bChinese)
{
    $str = '';
    if ($result = SqlGetMemberByIp($strIp)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strLink = GetMemberLink($record['id'], $bChinese);
            $str .= $strNewLine.$strLink.($bChinese ? '登录于' : ' login on ').$record['login'];
        }
        @mysql_free_result($result);
    }
    return $str;
}

function _ipLookupBlogCommentTable($strIp, $strNewLine, $bChinese)
{
    $strQuery = 'ip='.$strIp;
    $strWhere = SqlWhereFromUrlQuery($strQuery);
    $iTotal = SqlCountBlogComment($strWhere);
    if ($iTotal == 0)   return '';
        
    $str = $strNewLine;
	if ($result = SqlGetBlogComment($strWhere, 0, MAX_COMMENT_DISPLAY)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $str .= $strNewLine.GetSingleCommentDescription($record, $strWhere, $bChinese);
        }
        @mysql_free_result($result);
    }
    $str .= $strNewLine.GetAllCommentLink($strQuery, $bChinese).$strNewLine;
    return $str;
}

function _ipLookupIpAddressTable($strIp, $strNewLine, $bChinese)
{
    $str = '';
    if ($record = SqlGetIpAddressRecord($strIp))
    {
        $iVisit = intval($record['visit']);
        $iVisit += AcctCountBlogVisitor($strIp);
        $str .= $strNewLine.($bChinese ? '普通网页总访问次数' : 'Total normal page visit').': '.intval($iVisit);
        
        $str .= $strNewLine.($bChinese ? '总登录次数' : 'Total login').': '.$record['login'];
    }
    return $str;
}

function _ipLookupLocalDatabase($strIp, $strNewLine, $bChinese)
{
    $str = _ipLookupMemberTable($strIp, $strNewLine, $bChinese);        // Search member login
    $str .= _ipLookupBlogCommentTable($strIp, $strNewLine, $bChinese);  // Search blog comment
    $str .= _ipLookupIpAddressTable($strIp, $strNewLine, $bChinese);  // Search blog comment
    return $str;
}

function _convertTaobaoIp($str)
{
	if ($str == 'XX')	return '';
	return $str.' ';
}

function _ipLookupHttp($strIp, $strNewLine, $bChinese)
{
    $str = '';
    if ($bChinese)
    {
        $fStart = microtime(true);
        $arTaobao = TaobaoIpLookUp($strIp);
        $str .= $strNewLine.GetExternalLink(_getTaobaoIpLookUpUrl($strIp), '淘宝数据').': ';
        $str .= _convertTaobaoIp($arTaobao['country'])._convertTaobaoIp($arTaobao['area'])._convertTaobaoIp($arTaobao['region'])._convertTaobaoIp($arTaobao['city'])._convertTaobaoIp($arTaobao['county'])._convertTaobaoIp($arTaobao['isp']);
        $str .= DebugGetStopWatchDisplay($fStart);
    }
    
    $fStart = microtime(true);
    $arIpInfo = IpInfoIpLookUp($strIp);
    $str .= $strNewLine.GetExternalLink(_getIpInfoIpLookUpUrl($strIp), 'ipinfo.io').': ';
    $str .= $arIpInfo['country'].' '.$arIpInfo['region'].' '.$arIpInfo['city'].' '.$arIpInfo['postal'].' ['.$arIpInfo['loc'].'] '.$arIpInfo['hostname'].' '.$arIpInfo['org'];
    $str .= DebugGetStopWatchDisplay($fStart);
    
    return $str;
}
 
function IpLookupGetString($strIp, $strNewLine, $bChinese)
{
    $strIpId = SqlMustGetIpId($strIp);
    
    $str = $strIp._ipLookupHttp($strIp, $strNewLine, $bChinese);
    if ($ar = ProjectHoneyPotIpLookUp($strIp))
    {
        $str .= $strNewLine.GetExternalLink(PROJECT_HONEY_POT_URL.$strIp, 'projecthoneypot.org').': '._getProjectHoneyPotIpLookUpString($ar);
    }
    
    if ($strDns = DnsIpLookUp($strIp))
    {
        $str .= $strNewLine.'DNS: '.$strDns;
    }
    
    $str .= _ipLookupLocalDatabase($strIp, $strNewLine, $bChinese);
    return $str;
}

?>
