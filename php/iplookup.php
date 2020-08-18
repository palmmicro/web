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

function IpInfoIpLookUp($strIp, $sql)
{ 
    if ($str = url_get_contents(_getIpInfoIpLookUpUrl($strIp)))
    {
    	DebugString($str);
    	$ar = json_decode($str, true);
    	if (isset($ar['hostname']))
    	{
    		if ($ar['hostname'] == 'No Hostname')		unset($ar['hostname']);
    		else
    		{
    			if (strstr_array($ar['hostname'], array('bot', 'crawl', 'spider')))
    			{
					$sql->SetStatus(IP_STATUS_CRAWL, $strIp);
				}
			}
    	}
    	return $ar;
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

function _ipLookupBlogCommentTable($strIp, $page_sql, $strNewLine, $bChinese)
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
            $str .= $strNewLine.GetSingleCommentDescription($record, $strWhere, $page_sql, $bChinese);
        }
        @mysql_free_result($result);
    }
    $str .= $strNewLine.GetAllCommentLink($strQuery, $bChinese).$strNewLine;
    return $str;
}

function _ipLookupIpAddressTable($strIp, $sql, $visitor_sql, $strNewLine, $bChinese)
{
    $str = '';
    if ($record = $sql->GetRecord($strIp))
    {
        $iVisit = intval($record['visit']);
        $iVisit += $visitor_sql->CountBySrc($record['id']);
        $str .= $strNewLine.($bChinese ? '普通网页总访问次数' : 'Total normal page visit').': '.strval($iVisit);
        $str .= $strNewLine.($bChinese ? '总登录次数' : 'Total login').': '.$record['login'];
        if ($record['status'] != IP_STATUS_NORMAL)
        {
        	$str .= $strNewLine.'<font color=green>'.($bChinese ? '已标注爬虫' : 'Marked crawler').'</font>';
        }
    }
    return $str;
}

function IpLookupGetString($strIp, $sql, $visitor_sql, $page_sql, $strNewLine, $bChinese)
{
    $fStart = microtime(true);
    $str = $strIp.' '.GetVisitorLink(false, $bChinese).$strNewLine.GetExternalLink(_getIpInfoIpLookUpUrl($strIp), 'ipinfo.io').': ';
    if ($arInfo = IpInfoIpLookUp($strIp, $sql))
    {
    	if (isset($arInfo['error']) == false)
    	{
    		$str .= $arInfo['country'].' '.$arInfo['region'].' '.$arInfo['city'].' ['.$arInfo['loc'].'] '.$arInfo['org'];
    		if (isset($arInfo['postal']))	$str .= ' '.$arInfo['postal'];
    		if (isset($arInfo['hostname']))	$str .= ' '.$arInfo['hostname'];
    	}
    }
    $str .= DebugGetStopWatchDisplay($fStart);
    
    $str .= _ipLookupMemberTable($strIp, $strNewLine, $bChinese);        // Search member login
    $str .= _ipLookupBlogCommentTable($strIp, $page_sql, $strNewLine, $bChinese);  // Search blog comment
    $str .= _ipLookupIpAddressTable($strIp, $sql, $visitor_sql, $strNewLine, $bChinese);
    return $str;
}

?>
