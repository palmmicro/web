<?php
require_once('_visitorcommon.php');

function _echoBlogVisitorData($strIp, $iStart, $iNum, $bChinese)
{
    $arBlogId = array();
    $arIpId = array();
    if ($result = AcctGetBlogVisitor($strIp, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strBlogId = $record['dst_id'];
            $strUri = SqlGetUriByBlogId($strBlogId);
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
                $str = SqlGetIpAddress($strIpId);
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

function _getNavVisitorLink($strIp, $iStart, $iNum, $bChinese)
{
    if ($strIp)
    {
        $strId = 'ip='.$strIp;
        $iTotal = AcctCountBlogVisitor($strIp);
    }
    else
    {
        $strId = false;
        $iTotal = SqlCountTableData(VISITOR_TABLE);
    }
    return GetNavLink($strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _echoBlogVisitorParagraph($strIp, $iStart, $iNum, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('页面', 'IP', '日期', '时间');
    }
    else
    {
        $arColumn = array('Page', 'IP', 'Date', 'Time');
    }
    
    $strNavLink = _getNavVisitorLink($strIp, $iStart, $iNum, $bChinese);
    EchoVisitorParagraphBegin($arColumn, $strNavLink, $strIp, $bChinese);
    _echoBlogVisitorData($strIp, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoBlogVisitor($bChinese)
{
    $strIp = UrlGetQueryValue('ip');
    if ($strIp)
    {
        $str = IpLookupGetString($strIp, '<br />', $bChinese);
        $iPageCount = AcctGetSpiderPageCount($strIp);
        $str .= '<br />'.($bChinese ? '保存的不同页面数量' : 'Saved unique page number').': '.strval($iPageCount);
    }
    else
    {
        $str = GetVisitorTodayLink(SqlCountTableToday(VISITOR_TABLE), $bChinese);
    }
    EchoParagraph($str);
    
    $iStart = UrlGetQueryInt('start');
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    _echoBlogVisitorParagraph($strIp, $iStart, $iNum, $bChinese);
    EchoVisitorCommonLinks($bChinese);
}

    AcctAuth();
    
?>
