<?php
require_once('_visitorcommon.php');
require_once('/php/sql/sqlspider.php');
require_once('/php/sql/sqlweixin.php');

function _echoWeixinVisitorData($strOpenId, $iStart, $iNum, $bChinese)
{
    $arId = array();
    if ($result = SqlGetVisitor(WEIXIN_VISITOR_TABLE, SqlGetWeixinId($strOpenId), $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strContent = SqlGetSpiderParameter($record['dst_id']);
            $strContent = GetVisitorContentsDisplay($strContent);
            
            if ($strOpenId)     $strLink = GetVisitorSrcDisplay($strOpenId);
            else
            {
                $strId = $record['src_id'];
                $str = SqlGetWeixin($strId);
                $strDisplay = GetVisitorSrcDisplay($str);
                if (in_array($strId, $arId))    $strLink = $strDisplay;
                else
                {
                    $strLink = UrlGetPhpLink('/account/weixinvisitor', 'id='.$str, $strDisplay, $bChinese);
                    $arId[] = $strId;
                }
            }
            
            EchoVisitorItem($strContent, $strLink, $record);
        }
        @mysql_free_result($result);
    }
}

function _getNavWeixinVisitorLink($strOpenId, $iStart, $iNum, $bChinese)
{
    if ($strOpenId)
    {
        $strId = 'id='.$strOpenId;
        $iTotal = SqlCountVisitor(WEIXIN_VISITOR_TABLE, SqlGetWeixinId($strOpenId));
    }
    else
    {
        $strId = false;
        $iTotal = SqlCountTableData(WEIXIN_VISITOR_TABLE, false);
    }
    return UrlGetNavLink($strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _echoWeixinVisitorParagraph($strOpenId, $iStart, $iNum, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('参数', 'OpenID', '日期', '时间');
    }
    else
    {
        $arColumn = array('Parameter', 'OpenID', 'Date', 'Time');
    }
    
    $strNavLink = _getNavWeixinVisitorLink($strOpenId, $iStart, $iNum, $bChinese);
    $strAllLink = EchoVisitorParagraphBegin($arColumn, $strNavLink, $strOpenId, $bChinese);
    _echoWeixinVisitorData($strOpenId, $iStart, $iNum, $bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
    return $strAllLink;
}

function EchoWeixinVisitor($bChinese)
{
    $strOpenId = UrlGetQueryValue('id');
    if ($strOpenId)
    {
//        $str = IpLookupGetString($strIp, '<br />', $bChinese);
        $str = $strOpenId;
    }
    else
    {
        $str = GetVisitorTodayLink(SqlCountTableToday(WEIXIN_VISITOR_TABLE), $bChinese);
    }
    EchoParagraph($str);
    
    $iStart = UrlGetQueryInt('start', 0);
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    $strAllLink = _echoWeixinVisitorParagraph($strOpenId, $iStart, $iNum, $bChinese);
    
    EchoVisitorCommonLinks($strAllLink, $bChinese);
}

    AcctAuth();

?>
