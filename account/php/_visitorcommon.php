<?php
require_once('_account.php');
require_once('/php/ui/table.php');

function GetVisitorTodayLink($iCount, $bChinese)
{
    return CopyPhpLink('start=0&num='.$iCount, '今日访问', 'Visitors of Today', $bChinese);
}

function EchoVisitorItem($strContent, $strLink, $record)
{
    $strDate = substr($record['date'], 5);
    echo <<<END
    <tr>
        <td class=c1>$strContent</td>
        <td class=c1>$strLink</td>
        <td class=c1>$strDate</td>
        <td class=c1>{$record['time']}</td>
    </tr>
END;
}

function _getDeleteVisitorLink($strIp, $bChinese)
{
    if ($strIp)
    {
        if (AcctIsAdmin())
        {
            return GetDeleteLink('/account/php/_submitvisitor.php?delete='.$strIp, '访问记录', 'visitor records', $bChinese);
        }
    }
    return '';
}

function _getOrigVisitorLink($bChinese)
{
    if (UrlGetQueryString() == false)
    {
        $strOrigLink = '';
    }
    else
    {
        $strOrigLink = CopyPhpLink(false, '回访问首页', 'Back to Visitor Home', $bChinese);
    }
    return $strOrigLink;    
}

define ('MAX_VISITOR_CONTENTS', 35);
define ('MAX_VISITOR_SRC', 16);
function EchoVisitorParagraphBegin($arColumn, $strNavLink, $strSrc, $bChinese)
{
    $strOrigLink = _getOrigVisitorLink($bChinese);
    $strDeleteLink = _getDeleteVisitorLink($strSrc, $bChinese);
    EchoParagraphBegin($strNavLink.' '.$strOrigLink.' '.$strDeleteLink);
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="visitor">
    <tr>
        <td class=c1 width=350 align=center>{$arColumn[0]}</td>
        <td class=c1 width=160 align=center>{$arColumn[1]}</td>
        <td class=c1 width=50 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
    </tr>
END;
}

function GetVisitorSrcDisplay($strSrc)
{
    if (strlen($strSrc) > MAX_VISITOR_SRC)
    {
        $iLen = MAX_VISITOR_SRC - 3;
        return '...'.substr($strSrc, 0 - $iLen, $iLen);
    }
    return $strSrc;
}

function GetVisitorContentsDisplay($strContents)
{
    if (strlen($strContents) > MAX_VISITOR_CONTENTS)
    {
        $iLen = MAX_VISITOR_CONTENTS - 3;
        return substr($strContents, 0, $iLen).'...';
    }
    return $strContents;
}

function _getCategoryArray($bChinese)
{
    if ($bChinese)
    {
        return array(VISITOR_TABLE => '访问数据',
                      SPIDER_VISITOR_TABLE => '爬虫接口访问数据',
                      WEIXIN_VISITOR_TABLE => '微信访问数据',
                     );
    }
    else
    {
        return array(VISITOR_TABLE => 'Visitor Information',
                      SPIDER_VISITOR_TABLE => 'Crawler Interface Visitor',
                      WEIXIN_VISITOR_TABLE => 'Weixin Visitor',
                     );
    }
}

function EchoVisitorCommonLinks($bChinese)
{
    $str = GetCategoryLinks(_getCategoryArray, $bChinese, '/account/');
    EchoParagraph($str);
}

?>
