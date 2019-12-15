<?php
require_once('_visitorcommon.php');
require_once('/php/sql/sqlweixin.php');

function _echoWeixinVisitorData($strUser, $iStart, $iNum, $bChinese)
{
    $arId = array();
//	$sql = new WeixinSql();
//	$text_sql = new WeixinTextSql();
	$sql = new WeixinVisitorSql($strUser);
	$key_sql = $sql->GetKeySql();
	$log_sql = $sql->GetLogSql();
//    if ($result = SqlGetVisitor(TABLE_WEIXIN_VISITOR, $sql->GetId($strUser), $iStart, $iNum)) 
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
//            $strContent = $text_sql->GetKey($record['dst_id']);
            $strContent = $log_sql->GetKey($record['weixintext_id']);
            $strContent = GetVisitorContentsDisplay($strContent);
            
            if ($strUser)     $strLink = GetVisitorSrcDisplay($strUser);
            else
            {
//                $strId = $record['src_id'];
//				$str = $sql->GetKey($strId);
                $strId = $record['weixin_id'];
				$str = $key_sql->GetKey($strId);
                $strDisplay = GetVisitorSrcDisplay($str);
                if (in_array($strId, $arId))    $strLink = $strDisplay;
                else
                {
                    $strLink = GetPhpLink('/account/weixinvisitor', 'id='.$str, $strDisplay, false, $bChinese);
                    $arId[] = $strId;
                }
            }
            
            EchoVisitorItem($strContent, $strLink, $record);
        }
        @mysql_free_result($result);
    }
}

function _getNavWeixinVisitorLink($strUser, $iStart, $iNum, $bChinese)
{
    if ($strUser)
    {
        $strId = 'id='.$strUser;
//        $sql = new WeixinSql();
//        $iTotal = SqlCountVisitor(TABLE_WEIXIN_VISITOR, $sql->GetId($strUser));
    }
    else
    {
        $strId = false;
//        $iTotal = SqlCountTableData(TABLE_WEIXIN_VISITOR);
    }
    
   	$sql = new WeixinVisitorSql($strUser);
    $iTotal = $sql->Count(); 
    return GetNavLink($strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _echoWeixinVisitorParagraph($strUser, $iStart, $iNum, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('参数', 'OpenID', '日期', '时间');
    }
    else
    {
        $arColumn = array('Parameter', 'OpenID', 'Date', 'Time');
    }
    
    $strNavLink = _getNavWeixinVisitorLink($strUser, $iStart, $iNum, $bChinese);
    EchoVisitorParagraphBegin($arColumn, $strNavLink, $strUser, $bChinese);
    _echoWeixinVisitorData($strUser, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoWeixinVisitor($bChinese = true)
{
    $strUser = UrlGetQueryValue('id');
    if ($strUser)
    {
        $str = $strUser;
    }
    else
    {
//        $str = GetVisitorTodayLink(SqlCountTableToday(TABLE_WEIXIN_VISITOR), $bChinese);
        $str = '';
    }
    EchoParagraph($str);
    
    $iStart = UrlGetQueryInt('start');
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    _echoWeixinVisitorParagraph($strUser, $iStart, $iNum, $bChinese);
    EchoVisitorCommonLinks($bChinese);
}

    AcctAuth();

?>
