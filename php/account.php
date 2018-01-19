<?php
require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('sql.php');
require_once('email.php');
require_once('iplookup.php');
require_once('ui/table.php');
require_once('ui/commentparagraph.php');

require_once('sql/sqlmember.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlipaddress.php');
require_once('sql/sqlvisitor.php');
require_once('sql/sqlstockgroup.php');

function filter_var_email($strEmail)
{
    return filter_var($strEmail, FILTER_VALIDATE_EMAIL);
}

function AcctDeleteBlogVisitor($strIp, $strIpId, $iCount)
{
    SqlAddIpVisit($strIp, $iCount);
    return SqlDeleteVisitor(VISITOR_TABLE, $strIpId);
}

function AcctDeleteBlogVisitorByIp($strIp)
{
    if ($strIpId = SqlGetIpAddressId($strIp))
    {
        $iCount = SqlCountVisitor(VISITOR_TABLE, $strIpId);
        SqlSetIpStatus($strIp, IP_STATUS_NORMAL);
        AcctDeleteBlogVisitor($strIp, $strIpId, $iCount);
    }
}

function AcctDeleteMember($strMemberId)
{
	SqlDeleteStockGroupByMemberId($strMemberId);
	SqlDeleteBlogCommentByMemberId($strMemberId);
	SqlDeleteProfileByMemberId($strMemberId);
    SqlDeleteTableDataById('member', $strMemberId);
}

function AcctLogin($strEmail, $strPassword)
{
    if ($strMemberId = SqlExecLogin($strEmail, $strPassword))
    {
		session_regenerate_id();
		$_SESSION['SESS_ID'] = $strMemberId;
    }
    return $strMemberId;
}

function AcctLogout()
{
	// Unset the variables stored in session
	unset($_SESSION['SESS_ID']);
}

function AcctGetEmail()
{
    if ($strEmail = SqlGetEmailById($_SESSION['SESS_ID']))
	{
	    return $strEmail;
	}
	return '';
}

function AcctIsAdmin()
{
    if (AcctGetEmail() == ADMIN_EMAIL)
	{
	    return true;
	}
	return false;
}

function AcctIsLogin()
{
	// Check whether the session variable SESS_ID is present or not
    $strMemberId = $_SESSION['SESS_ID'];
	if (!isset($strMemberId) || (trim($strMemberId) == '')) 
	{
		return false;
	}
	return $strMemberId;
}

function AcctSwitchToLogin()
{
    SwitchSetSess();
    SwitchTo('/account/login');
}

function AcctIsReadOnly($strMemberId)
{
    if (AcctIsAdmin())  return false;
    if ($strMemberId)
    {
        if ($strMemberId == $_SESSION['SESS_ID'])   return false;
    }
    return true;
}

function AcctSessionStart()
{
    session_start();
    SqlConnectDatabase();
}

function AcctMustLogin()
{
    $strMemberId = AcctIsLogin(); 
    if ($strMemberId == false) 
    {
        AcctSwitchToLogin();
    }
	return $strMemberId;
}

function AcctAuth()
{
    AcctSessionStart();
    return AcctMustLogin();
}

function AcctEmailSpiderReport($strIp, $strText, $strSubject)
{
    EmailDebug($strText, $strSubject.' from '.$strIp); 
}

function AcctGetBlogVisitor($strIp, $iStart, $iNum)
{
/*    if ($strIpId = SqlGetIpAddressId($strIp))
    {
        return SqlGetVisitor(VISITOR_TABLE, $strIpId, $iStart, $iNum);
    }
    return false;*/
    return SqlGetVisitor(VISITOR_TABLE, SqlGetIpAddressId($strIp), $iStart, $iNum);
}

function AcctGetSpiderPageCount($strIp)
{
    $ar = array();
	if ($result = AcctGetBlogVisitor($strIp, 0, 0)) 
	{
	    while ($record = mysql_fetch_assoc($result)) 
	    {
            $ar[] = $record['dst_id'];
	    }
	    @mysql_free_result($result);
	}
	$ar = array_unique($ar);
	return count($ar);
}

function _checkSearchEngineSpider($strIp, $iCount)
{
    $arIpInfo = IpInfoIpLookUp($strIp);
    $str = strtolower($arIpInfo['org']);
    if (strchr($str, 'microsoft') || strchr($str, 'yahoo') || strchr($str, 'yandex'))
    {
        AcctEmailSpiderReport($strIp, 'Known company: '.$arIpInfo['org'], 'Known spider');
        return true;
    }
    else
    {
	    $iPageCount = AcctGetSpiderPageCount($strIp);
	    $strText = $arIpInfo['hostname'].' '.$arIpInfo['org'].' '.strval($iCount).' '.strval($iPageCount);
	    if ($iPageCount >= 10)
	    {
	        AcctEmailSpiderReport($strIp, $strText, 'Unknown spider');
	        return true;
	    }
        if ($record = SqlGetIpAddressRecord($strIp))
        {
            if ($record['status'] == IP_STATUS_NORMAL)
            {
                AcctEmailSpiderReport($strIp, $strText, 'Blocked spider');
                SqlSetIpStatus($strIp, IP_STATUS_BLOCKED);
            }
        }
    }
    return false;
}

function AcctCountBlogVisitor($strIp)
{
    return SqlCountVisitor(VISITOR_TABLE, SqlGetIpAddressId($strIp));
}

function _checkSpiderBehaviour($strIp, $strIpId)
{
	$iCount = AcctCountBlogVisitor($strIp);
	if ($iCount >= 1000)
	{
	    if (ProjectHoneyPotCheckSearchEngine($strIp) || DnsCheckSearchEngine($strIp) || _checkSearchEngineSpider($strIp, $iCount))
	    {
	        AcctDeleteBlogVisitor($strIp, $strIpId, $iCount);
	        return false;
	    }
	    return true;
	}
	return false;
}

function AcctGetBlogId()
{
    SqlCreateBlogTable();
    $strUri = UrlGetUri();	                        // /woody/blog/entertainment/20140615cn.php
	if (($strBlogId = SqlGetBlogIdByUri($strUri)) == false)
	{    // This uri not in blog table yet, insert it
		$strEmail = AcctGetEmailFromBlogUri($strUri);
		if ($strAuthorId = SqlGetIdByEmail($strEmail))                		             
		{
			$strBlogId = SqlInsertBlog($strAuthorId, $strUri);
		}
	}
    return $strBlogId;
}

function AcctCheckLogin()
{
	if (($strMemberId = AcctIsLogin()) == false)
	{
	    SqlCreateVisitorTable(VISITOR_TABLE);
	    $strIp = UrlGetIp();
	    $strIpId = SqlMustGetIpId($strIp); 
	    if (_checkSpiderBehaviour($strIp, $strIpId))
	    {
	        AcctSwitchToLogin();
	    }
	    else
	    {
	        $strBlogId = AcctGetBlogId();
	        SqlInsertVisitor(VISITOR_TABLE, $strBlogId, $strIpId);
	    }
	}
    return $strMemberId;	
}

function AcctNoAuth()
{
    AcctSessionStart();
    return AcctCheckLogin();
}

function AcctEmailQueryLogin()
{
    if ($strEmail = UrlGetQueryValue('email'))
    {
        AcctCheckLogin();
        return SqlGetIdByEmail($strEmail); 
    }
    return AcctMustLogin();
}

function AcctEmailAuth()
{
    AcctSessionStart();
    return AcctEmailQueryLogin();
}

function AcctGetEmailFromBlogUri($strUri)
{
	$iPos = strpos($strUri, '/', 1);
	$strName = substr($strUri, 1, $iPos - 1);
	if ($strName == 'woody' || $strName == 'chishin' || $strName == 'laosun' || $strName == 'tangli')
	{
	    return UrlGetEmail($strName);
	}
	return ADMIN_EMAIL;
}

function AcctGetBlogLink($strBlogId)
{
    $strBlogUri = SqlGetUriByBlogId($strBlogId);
    if ($strBlogUri)
    {
        return UrlGetLink($strBlogUri, $strBlogUri);
    }
    return '';
}

function AcctGetMemberDisplay($strMemberId)
{
	if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
	{
	    return SqlGetEmailById($strMemberId);
	}
	return $strName;
}

function AcctGetMemberLink($strMemberId, $bChinese)
{
	if ($strEmail = SqlGetEmailById($strMemberId))
	{
	    if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
	    {
	        $strName = $strEmail;
	    }
	    return UrlGetPhpLink('/account/profile', 'email='.$strEmail, $strName, $bChinese);
	}
    return '';
}

function _getIpLink($strTitle, $strIp, $bChinese)
{
    return UrlGetPhpLink('/account/'.$strTitle, 'ip='.$strIp, $strIp, $bChinese);
}

function AcctGetIpLink($strIp, $bChinese)
{
    return _getIpLink('ip', $strIp, $bChinese);
}

function AcctGetVisitorLink($strIp, $bChinese)
{
    return _getIpLink(VISITOR_TABLE, $strIp, $bChinese);
}

function AcctGetSpiderVisitorLink($strIp, $bChinese)
{
    return _getIpLink(SPIDER_VISITOR_TABLE, $strIp, $bChinese);
}

function AcctGetLoginLink($strCn, $strUs, $bChinese)
{
    return UrlBuildPhpLink('/account/login', false, $strCn, $strUs, $bChinese);
}

function AcctGetAllCommentLink($strQuery, $bChinese)
{
    return UrlBuildPhpLink('/account/comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

function AcctEchoBlogComments($strMemberId, $bChinese)
{
    $strQuery = 'member_id='.$strMemberId;
    $strWhere = SqlWhereFromUrlQuery($strQuery);
    $iTotal = SqlCountBlogComment($strWhere);
    if ($iTotal == 0)   return;

    $str = $bChinese ? '评论' : 'Comment';
    if ($iTotal > NAX_COMMENT_DISPLAY)
    {
        $str .= ' '.AcctGetAllCommentLink($strQuery, $bChinese);
    }
    EchoParagraph($str);
    EchoCommentParagraphs($strMemberId, $strWhere, 0, NAX_COMMENT_DISPLAY, $bChinese);    
}

?>
