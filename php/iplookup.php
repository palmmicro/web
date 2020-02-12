<?php
require_once('debug.php');
require_once('sql/sqlipaddress.php');
require_once('ui/commentparagraph.php');

define('IPINFO_IO_IP_URL', 'http://ipinfo.io/');
function _getIpInfoIpLookUpUrl($sql)
{
    return IPINFO_IO_IP_URL.$sql->GetKey().'/json';
}

function strstr_array($strHaystack, $arNeedle)
{
	foreach ($arNeedle as $strNeedle)
	{
		if (stripos($strHaystack, $strNeedle) !== false)		return true;
	}
	return false;
}

function IpInfoIpLookUp($sql)
{ 
    if ($str = url_get_contents(_getIpInfoIpLookUpUrl($sql)))
    {
    	DebugString($str);
    	$ar = json_decode($str, true);
    	if (isset($ar['hostname']))
    	{
    		if ($ar['hostname'] == 'No Hostname')		unset($ar['hostname']);
    		else
    		{
    			if (strstr_array($ar['hostname'], array('ahrefs.com', 'bot', 'crawl', 'spider', 'webmeup.com')))
    			{
					$sql->SetStatus(IP_STATUS_CRAWL);
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

function _ipLookupIpAddressTable($sql, $strNewLine, $bChinese)
{
    $str = '';
    if ($record = $sql->GetRecord())
    {
        $iVisit = intval($record['visit']);
        $iVisit += AcctCountBlogVisitor($sql);
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

function IpLookupGetString($sql, $strNewLine, $bChinese)
{
    if (($strIp = $sql->GetKey()) === false)	return '';
    
    $fStart = microtime(true);
    $str = $strIp.$strNewLine.GetExternalLink(_getIpInfoIpLookUpUrl($sql), 'ipinfo.io').': ';
    if ($arInfo = IpInfoIpLookUp($sql))
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
    $str .= _ipLookupBlogCommentTable($strIp, $strNewLine, $bChinese);  // Search blog comment
    $str .= _ipLookupIpAddressTable($sql, $strNewLine, $bChinese);
    return $str;
}

?>
