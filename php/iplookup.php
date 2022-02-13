<?php
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

class IpLookupAccount extends CommentAccount
{
    function _ipInfoLookUp($strIp)
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
    					$this->SetCrawler($strIp);
    				}
    			}
    		}
    		return $ar;
    	}
    	return false;
    }

    function _pageCommentLookup($strIp, $bChinese)
    {
		$comment_sql = $this->GetCommentSql();
    	$strWhere = $this->BuildWhereByIp($strIp);
	    $iTotal = $this->CountComments($strWhere);
	    if ($iTotal == 0)   return '';
        
	    $str = '<br />';
	    if ($result = $comment_sql->GetAll($strWhere, 0, MAX_COMMENT_DISPLAY)) 
	    {
	    	while ($record = mysql_fetch_assoc($result)) 
	    	{
	    		$str .= '<br />'.$this->GetCommentDescription($record, $strWhere, $bChinese);
	    	}
	    	@mysql_free_result($result);
	    }
	    $str .= '<br />'.strval($iTotal).' '.GetAllCommentLink(TABLE_IP.'='.$strIp, $bChinese).'<br />';
	    return $str;
	}

	function _visitorLookup($strIp, $bChinese)
	{
		$str = '';
		$visitor_sql = $this->GetVisitorSql();
		$sql = $this->GetIpSql();
		if ($record = $sql->GetRecord($strIp))
		{
			$iVisit = intval($record['visit']);
			$iVisit += $visitor_sql->CountBySrc($record['id']);
			$str .= '<br />'.($bChinese ? '普通网页总访问次数' : 'Total normal page visit').': '.strval($iVisit);
			$str .= '<br />'.($bChinese ? '总登录次数' : 'Total login').': '.$record['login'];
			switch ($record['status'])
			{
			case IP_STATUS_CRAWLER:
				$str .= '<br />'.GetFontElement(($bChinese ? '已标注爬虫' : 'Marked crawler'), 'green');
			    break;
				
			case IP_STATUS_MALICIOUS:
				$str .= '<br />'.GetFontElement($bChinese ? '已标注恶意IP' : 'Marked malicious IP');
			    break;
			}
		}
		return $str;
	}

    function IpLookupString($strIp, $bChinese)
    {
    	$fStart = microtime(true);
    	$str = $strIp.' '.GetVisitorLink(false, $bChinese).'<br />'.GetExternalLink(_getIpInfoIpLookUpUrl($strIp), 'ipinfo.io').': ';
    	if ($arInfo = $this->_ipInfoLookUp($strIp))
    	{
    		if (isset($arInfo['error']) == false)
    		{
    			$str .= $arInfo['country'].' '.$arInfo['region'].' '.$arInfo['city'].' ['.$arInfo['loc'].'] '.$arInfo['org'];
    			if (isset($arInfo['postal']))	$str .= ' '.$arInfo['postal'];
    			if (isset($arInfo['hostname']))	$str .= ' '.$arInfo['hostname'];
    		}
    	}
    	$str .= DebugGetStopWatchDisplay($fStart);
    
    	$str .= _ipLookupMemberTable($strIp, '<br />', $bChinese);		// Search member login
    	$str .= $this->_pageCommentLookup($strIp, $bChinese);  		// Search blog comment
    	$str .= $this->_visitorLookup($strIp, $bChinese);
    	return $str;
    }
}

?>
