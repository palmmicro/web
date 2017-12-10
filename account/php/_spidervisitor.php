<?php
require_once('_visitorcommon.php');
require_once('/php/sql/sqlspider.php');

function _echoSpiderVisitorData($strIp, $iStart, $iNum, $bChinese)
{
    $arId = array();
    if ($result = SqlGetVisitor(SPIDER_VISITOR_TABLE, SqlGetIpAddressId($strIp), $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strContent = SqlGetSpiderParameter($record['dst_id']);
            $strContent = GetVisitorContentsDisplay($strContent);
            
            if ($strIp)     $strLink = $strIp;
            else
            {
                $strId = $record['src_id'];
                $str = SqlGetIpAddress($strId);
                if (in_array($strId, $arId))    $strLink = $str;
                else
                {
                    $strLink = AcctGetSpiderVisitorLink($str, $bChinese);
                    $arId[] = $strId;
                }
            }
            
            EchoVisitorItem($strContent, $strLink, $record);
        }
        @mysql_free_result($result);
    }
}

function _getNavSpiderVisitorLink($strIp, $iStart, $iNum, $bChinese)
{
    if ($strIp)
    {
        $strId = 'ip='.$strIp;
        $iTotal = SqlCountVisitor(SPIDER_VISITOR_TABLE, SqlGetIpAddressId($strIp));
    }
    else
    {
        $strId = false;
        $iTotal = SqlCountTableData(SPIDER_VISITOR_TABLE, false);
    }
    return UrlGetNavLink(AccountGetPathTitle(), $strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _echoSpiderVisitorParagraph($strIp, $iStart, $iNum, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('参数', 'IP', '日期', '时间');
    }
    else
    {
        $arColumn = array('Parameter', 'IP', 'Date', 'Time');
    }
    
    $strNavLink = _getNavSpiderVisitorLink($strIp, $iStart, $iNum, $bChinese);
    $strAllLink = EchoVisitorParagraphBegin($arColumn, $strNavLink, $strIp, $bChinese);
    _echoSpiderVisitorData($strIp, $iStart, $iNum, $bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
    return $strAllLink;
}

function EchoSpiderVisitor($bChinese)
{
    $strIp = UrlGetQueryValue('ip');
    if ($strIp)
    {
        $str = IpLookupGetString($strIp, '<br />', $bChinese);
    }
    else
    {
        $str = GetVisitorTodayLink(SqlCountTableToday(SPIDER_VISITOR_TABLE), $bChinese);
    }
    EchoParagraph($str);
    
    $iStart = UrlGetQueryInt('start', 0);
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    $strAllLink = _echoSpiderVisitorParagraph($strIp, $iStart, $iNum, $bChinese);
    
    EchoVisitorCommonLinks($strAllLink, $bChinese);
}

    AcctAuth();

?>
