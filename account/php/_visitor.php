<?php
require_once('_account.php');
require_once('/php/iplookup.php');
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

function _echoBlogVisitorData($strId, $visitor_sql, $page_sql, $iStart, $iNum, $bChinese)
{
    $arBlogId = array();
    $arId = array();

    if ($result = $visitor_sql->GetDataBySrc($strId, $iStart, $iNum)) 
    {
   		$strDstIndex = $visitor_sql->GetDstKeyIndex();
   		$strSrcIndex = $visitor_sql->GetSrcKeyIndex();
        while ($record = mysql_fetch_assoc($result)) 
        {
			$ar = array($record['date'], GetHM($record['time']));

			$strDstId = $record[$strDstIndex];
			$strUri = $page_sql->GetKey($strDstId);
            $strUriLink = ltrim($strUri, '/');
            $strUriLink = _getVisitorContentsDisplay($strUriLink);
			$ar[] = SelectColumnItem($strUriLink, GetInternalLink($strUri, $strUriLink), $strDstId, $arBlogId);
            
            if ($strId == false)
            {
            	$strSrcId = $record[$strSrcIndex];
				$strIp = GetIp($strSrcId);
				$ar[] = SelectColumnItem($strIp, GetVisitorLink($strIp, $bChinese), $strSrcId, $arId);
            }
            
		    EchoTableColumn($ar);
        }
        @mysql_free_result($result);
    }
}

function _echoBlogVisitorParagraph($strIp, $strId, $visitor_sql, $page_sql, $iStart, $iNum, $bAdmin, $bChinese)
{
	$ar = array(new TableColumnDate(false, $bChinese), new TableColumnTime($bChinese), new TableColumn(($bChinese ? '页面' : 'Page'), MAX_VISITOR_CONTENTS * 10));
    
	$str = ' ';
    if ($strIp)
    {
        $strQuery = TABLE_IP.'='.$strIp;
        $iTotal = $visitor_sql->CountBySrc($strId);
        
    	$str .= GetIpLink($strIp, $bChinese);
        if ($bAdmin)
        {
            $str .= ' '.GetDeleteLink('/php/_submitdelete.php?'.$strQuery, '访问记录', 'Visitor Record', $bChinese);
            $str .= ' '.GetInternalLink('/php/_submitoperation.php?'.$strQuery, '标注爬虫');
        }
    }
    else
    {
        $strQuery = false;
        $iTotal = $visitor_sql->CountData();
        
    	$ar[] = new TableColumnIP();
    }
    
    $strNavLink = GetNavLink($strQuery, $iTotal, $iStart, $iNum, $bChinese);

	EchoTableParagraphBegin($ar, TABLE_VISITOR, $strNavLink.$str);
    _echoBlogVisitorData($strId, $visitor_sql, $page_sql, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoAll($bChinese = true)
{
    global $acct;
    
    $strIp = $acct->GetQuery();
	if (filter_valid_ip($strIp) == false)
	{
		$strIp = false;
	}

    $visitor_sql = $acct->GetVisitorSql();
    if ($strIp)
    {
        $str = $acct->IpLookupString($strIp, $bChinese);
        $strId = GetIpId($strIp);
        $iPageCount = $visitor_sql->CountUniqueDst($strId);
        $str .= '<br />'.($bChinese ? '保存的不同页面数量' : 'Saved unique page number').': '.strval($iPageCount);
    }
    else
    {
        $strId = false;
        $iCount = $visitor_sql->CountToday();
        $str = '今日访问: '.strval($iCount);
    }
    EchoParagraph($str);
    
    _echoBlogVisitorParagraph($strIp, $strId, $visitor_sql, $acct->GetPageSql(), $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin(), $bChinese);
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

   	$acct = new IpLookupAccount(TABLE_IP, true);	// Auth to  restrict robot ip lookup
?>
