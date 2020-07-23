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
            
//            EchoVisitorItem($strUriLink, $strIpLink, $record);
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
/*    if ($bChinese)     
    {
        $arColumn = array('页面', 'IP', '日期', '时间');
    }
    else
    {
        $arColumn = array('Page', 'IP', 'Date', 'Time');
    }
*/    
    $strNavLink = _getNavVisitorLink($sql, $strIp, $iStart, $iNum, $bChinese);
    $str = $strNavLink;
    if (UrlGetQueryString())	$str .= ' '.CopyPhpLink(false, '回访问首页', 'Back to Visitor Home', $bChinese);
    if ($strIp)
    {
        if ($bAdmin)
        {
        	$strQuery = '?'.TABLE_IP.'='.$strIp;
            $str .= ' '.GetDeleteLink('/php/_submitdelete.php'.$strQuery, '访问记录', 'Visitor Record', $bChinese);
            $str .= ' '.GetInternalLink('/php/_submitoperation.php'.$strQuery, '拉黑');
        }
    }

//    EchoVisitorParagraphBegin($arColumn, $strNavLink, $sql->GetKey(), $bChinese);
	EchoTableParagraphBegin(array(new TableColumn(($bChinese ? '页面' : 'Page'), 350),
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
        $str = GetVisitorTodayLink(SqlCountTableToday(VISITOR_TABLE), $bChinese);
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
	$acct->Auth();
?>
