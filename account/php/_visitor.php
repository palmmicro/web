<?php
require_once('_visitorcommon.php');

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
            $strUriLink = GetVisitorContentsDisplay($strUriLink);
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
            
            EchoVisitorItem($strUriLink, $strIpLink, $record);
        }
        @mysql_free_result($result);
    }
}

function _getNavVisitorLink($sql, $iStart, $iNum, $bChinese)
{
    if ($strIp = $sql->GetKey())
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

function _echoBlogVisitorParagraph($sql, $iStart, $iNum, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('页面', 'IP', '日期', '时间');
    }
    else
    {
        $arColumn = array('Page', 'IP', 'Date', 'Time');
    }
    
    $strNavLink = _getNavVisitorLink($sql, $iStart, $iNum, $bChinese);
    EchoVisitorParagraphBegin($arColumn, $strNavLink, $sql->GetKey(), $bChinese);
    _echoBlogVisitorData($sql, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoBlogVisitor($bChinese = true)
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
        $str = GetVisitorTodayLink(SqlCountTableToday(VISITOR_TABLE), $bChinese);
    }
    EchoParagraph($str);
    
    _echoBlogVisitorParagraph($sql, $acct->GetStart(), $acct->GetNum(), $bChinese);
}

   	$acct = new AcctStart();
	$acct->Auth();
?>
