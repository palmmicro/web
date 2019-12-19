<?php
require_once('debug.php');
require_once('sql/sqlipaddress.php');
require_once('ui/commentparagraph.php');

define('IPINFO_IO_IP_URL', 'http://ipinfo.io/');
function _getIpInfoIpLookUpUrl($strIp)
{
    return IPINFO_IO_IP_URL.$strIp.'/json';
}

function strstr_array($strHaystack, $arNeedle)
{
	foreach ($arNeedle as $strNeedle)
	{
		if (stripos($strHaystack, $strNeedle) !== false)		return true;
	}
	return false;
}

function IpInfoIpLookUp($strIp)
{ 
	$ar = array();
    $strUrl = _getIpInfoIpLookUpUrl($strIp); 
    if ($str = url_get_contents($strUrl))
    {
    	DebugString($str);
    	$ar = json_decode($str, true);
    	if (isset($ar['hostname']))
    	{
    		if ($ar['hostname'] == 'No Hostname')		unset($ar['hostname']);
    		else
    		{
    			if (strstr_array($ar['hostname'], array('ahrefs.com', 'bot', 'crawl', 'spider')))
    			{
					$sql = new IpSql($strIp);
					$sql->SetStatus(IP_STATUS_CRAWL);
				}
			}
    	}
    }
    return $ar;
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
   	$sql = new IpSql();
    if ($record = $sql->GetRecord($strIp))
    {
        $iVisit = intval($record['visit']);
        $iVisit += AcctCountBlogVisitor($strIp);
        $str .= $strNewLine.($bChinese ? '普通网页总访问次数' : 'Total normal page visit').': '.intval($iVisit);
        $str .= $strNewLine.($bChinese ? '总登录次数' : 'Total login').': '.$record['login'];
        if ($record['status'] == IP_STATUS_BLOCKED)
        {
        	$str .= $strNewLine.'<font color=red>'.($bChinese ? '被禁止访问' : 'Blocked').'</font>';
        }
        else if ($record['status'] == IP_STATUS_CRAWL)
        {
        	$str .= $strNewLine.'<font color=green>'.($bChinese ? '已标注爬虫' : 'Marked crawler').'</font>';
        }
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

function IpLookupGetString($strIp, $strNewLine, $bChinese)
{
	if (filter_valid_ip($strIp) == false)	return '';
	
	$sql = new IpSql($strIp);
    $str = $strIp;
    
    $fStart = microtime(true);
    $str .= $strNewLine.GetExternalLink(_getIpInfoIpLookUpUrl($strIp), 'ipinfo.io').': ';
    $arIpInfo = IpInfoIpLookUp($strIp);
    if (isset($arIpInfo['error']) == false)
    {
    	$str .= $arIpInfo['country'].' '.$arIpInfo['region'].' '.$arIpInfo['city'].' ['.$arIpInfo['loc'].'] '.$arIpInfo['org'];
    	if (isset($arIpInfo['postal']))		$str .= ' '.$arIpInfo['postal'];
    	if (isset($arIpInfo['hostname']))	$str .= ' '.$arIpInfo['hostname'];
    }
    $str .= DebugGetStopWatchDisplay($fStart);
    
    $str .= _ipLookupLocalDatabase($strIp, $strNewLine, $bChinese);
    return $str;
}

?>
