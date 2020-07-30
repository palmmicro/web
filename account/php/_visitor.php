<?php
require_once('_account.php');
require_once('/php/ui/table.php');

define('MAX_VISITOR_CONTENTS', 35);
function _getVisitorContentsDisplay($strContents)
{
    if (strlen($strContents) > MAX_VISITOR_CONTENTS)
    {
        $iLen = MAX_VISITOR_CONTENTS - 3;
        return substr($strContents, 0, $iLen).'...';
    }
    return $strContents;
}

function _echoBlogVisitorData($sql, $iStart, $iNum, $bChinese)
{
    $arBlogId = array();
    $arIpId = array();

    $strIp = $sql->GetKey();    
	$page_sql = new PageSql();
    if ($result = AcctGetBlogVisitor($sql, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strBlogId = $record['dst_id'];
			$strUri = $page_sql->GetKey($strBlogId);
            $strUriLink = ltrim($strUri, '/');
            $strUriLink = _getVisitorContentsDisplay($strUriLink);
            if (!in_array($strBlogId, $arBlogId))
            {
                $strUriLink = GetInternalLink($strUri, $strUriLink);
                $arBlogId[] = $strBlogId;
            }
            
            if ($strIp)     $strIpLink = $strIp;
            else
            {
                $strIpId = $record['src_id'];
				$str = $sql->GetKey($strIpId);
                if (in_array($strIpId, $arIpId))    $strIpLink = $str;
                else
                {
                    $strIpLink = GetVisitorLink($str, $bChinese);
                    $arIpId[] = $strIpId;
                }
            }
            
		    EchoTableColumn(array($strUriLink, $strIpLink, $record['date'], GetHM($record['time'])));
        }
        @mysql_free_result($result);
    }
}

function _getNavVisitorLink($sql, $strIp, $iStart, $iNum, $bChinese)
{
    if ($strIp)
    {
        $strId = 'ip='.$strIp;
        $iTotal = AcctCountBlogVisitor($sql);
    }
    else
    {
        $strId = false;
        $iTotal = SqlCountTableData(VISITOR_TABLE);
    }
    return GetNavLink($strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _echoBlogVisitorParagraph($sql, $strIp, $iStart, $iNum, $bAdmin, $bChinese)
{
    $strNavLink = _getNavVisitorLink($sql, $strIp, $iStart, $iNum, $bChinese);
    $str = $strNavLink;
    if (UrlGetQueryString())	$str .= ' '.CopyPhpLink(false, '回访问首页', 'Back to Visitor Home', $bChinese);
    if ($strIp)
    {
    	$str .= ' '.GetIpLink($strIp, $bChinese);
        if ($bAdmin)
        {
        	$strQuery = '?'.TABLE_IP.'='.$strIp;
            $str .= ' '.GetDeleteLink('/php/_submitdelete.php'.$strQuery, '访问记录', 'Visitor Record', $bChinese);
            $str .= ' '.GetInternalLink('/php/_submitoperation.php'.$strQuery, '拉黑');
            $str .= ' '.GetInternalLink('/php/_submitoperation.php?crawl='.$strIp, '标注爬虫');
        }
    }

	EchoTableParagraphBegin(array(new TableColumn(($bChinese ? '页面' : 'Page'), MAX_VISITOR_CONTENTS * 10),
								   new TableColumnIP(),
								   new TableColumnDate(false, $bChinese),
								   new TableColumnTime($bChinese)
								   ), VISITOR_TABLE, $str);

    _echoBlogVisitorData($sql, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoAll($bChinese = true)
{
    global $acct;
    
    $strIp = UrlGetQueryValue('ip');
    $sql = new IpSql($strIp);
    if ($strIp = $sql->GetKey())
    {
        $str = IpLookupGetString($sql, '<br />', $bChinese);
        $iPageCount = AcctGetSpiderPageCount($sql);
        $str .= '<br />'.($bChinese ? '保存的不同页面数量' : 'Saved unique page number').': '.strval($iPageCount);
    }
    else
    {
        $iCount = SqlCountTableToday(VISITOR_TABLE);
        $str = ($iCount > 0)	? CopyPhpLink('start=0&num='.$iCount, '今日访问', 'Visitors of Today', $bChinese) : '';
    }
    EchoParagraph($str);
    
    _echoBlogVisitorParagraph($sql, $strIp, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin(), $bChinese);
}

function EchoMetaDescription($bChinese = true)
{
    if ($bChinese)
    {
    	$str = '用户访问数据页面. 用于观察IP攻击的异常状况, 用户登录后会自动清除该IP之前的记录. 具体的用户统计工作还是由Google Analytics和Google Adsense完成.';
    }
    else
    {
    	$str = 'Visitor data page used to view IP attacks. The detailed user information is still using Google Analytics and Google Adsense.';
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = $bChinese ? '用户访问数据' : 'Visitor Data';
    echo $str;
}

   	$acct = new DataAccount();
   	$acct->Auth();		// restrict robot ip lookup
?>
