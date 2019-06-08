<?php
//require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('sql.php');
require_once('iplookup.php');
require_once('ui/table.php');

//require_once('sql/sqlmember.php');
//require_once('sql/sqlblog.php');
require_once('sql/sqlipaddress.php');
//require_once('sql/sqlvisitor.php');
require_once('sql/sqlstockgroup.php');
require_once('sql/sqlfundpurchase.php');

function _deleteVisitor($strIp, $strIpId, $iCount)
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
        _deleteVisitor($strIp, $strIpId, $iCount);
    }
}

function AcctDeleteMember($strMemberId)
{
	SqlDeleteFundPurchaseByMemberId($strMemberId);
	SqlDeleteStockGroupByMemberId($strMemberId);
	SqlDeleteBlogCommentByMemberId($strMemberId);
	SqlDeleteProfileByMemberId($strMemberId);
    SqlDeleteTableDataById(TABLE_MEMBER, $strMemberId);
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

function AcctGetEmail($strLoginId = false)
{
	if ($strLoginId == false)
	{
		if (isset($_SESSION['SESS_ID']))		$strLoginId = $_SESSION['SESS_ID'];
	}
	
	if ($strLoginId)
	{
		if ($strEmail = SqlGetEmailById($strLoginId))	return $strEmail;
	}
	return '';
}

function AcctIsAdmin($strLoginId = false)
{
    if (AcctGetEmail($strLoginId) == ADMIN_EMAIL)
	{
	    return true;
	}
	return false;
}

function AcctIsLogin()
{
	// Check whether the session variable SESS_ID is present or not
    $strMemberId = isset($_SESSION['SESS_ID']) ? $_SESSION['SESS_ID'] : false;
	if ($strMemberId)
	{
		if (trim($strMemberId) == '')	return false;
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
    	if (isset($_SESSION['SESS_ID']))
    	{
    		if ($strMemberId == $_SESSION['SESS_ID'])   return false;
    	}
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

function AcctGetBlogVisitor($strIp, $iStart = 0, $iNum = 0)
{
    return SqlGetVisitor(VISITOR_TABLE, SqlGetIpAddressId($strIp), $iStart, $iNum);
}

function AcctGetSpiderPageCount($strIp)
{
    $ar = array();
	if ($result = AcctGetBlogVisitor($strIp)) 
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
    $str = $arIpInfo['org'];
    if (strstr_array($str, array('microsoft', 'yahoo', 'yandex')))
    {
        trigger_error('Known company: '.$arIpInfo['org']);
        return true;
    }
    else
    {
	    $iPageCount = AcctGetSpiderPageCount($strIp);
	    $strText = $arIpInfo['hostname'].' '.$arIpInfo['org'].' '.strval($iCount).' '.strval($iPageCount);
	    if ($iPageCount >= 10)
	    {
	        trigger_error('Unknown spider<br />'.$strText);
	        return true;
	    }
        if ($record = SqlGetIpAddressRecord($strIp))
        {
            if ($record['status'] == IP_STATUS_NORMAL)
            {
                trigger_error('Blocked spider<br />'.$strText);
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
	        _deleteVisitor($strIp, $strIpId, $iCount);
	        return false;
	    }
	    return true;
	}
	return false;
}

function AcctGetBlogId()
{
    $strUri = UrlGetUri();	                        // /woody/blog/entertainment/20140615cn.php
	if ($strAuthorId = AcctGetMemberIdFromBlogUri($strUri))
	{
		$sql = new BlogSql($strAuthorId);
		if ($strBlogId = $sql->GetId($strUri))
		{
			return $strBlogId;
		}
		else
		{
			if ($sql->Insert($strUri))
			{
				return $sql->GetId($strUri);
			}
		}
	}
	return false;
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
	        if ($strBlogId = AcctGetBlogId())
	        {
	        	SqlInsertVisitor(VISITOR_TABLE, $strBlogId, $strIpId);
	        }
	    }
	}
    return $strMemberId;	
}

function AcctNoAuth()
{
    AcctSessionStart();
    return AcctCheckLogin();
}

function AcctGetMemberId()
{
    if ($strEmail = UrlGetQueryValue('email'))
    {
        return SqlGetIdByEmail($strEmail); 
    }
    return AcctIsLogin();
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

function AcctAdminCommand($callback)
{
	AcctNoAuth();
	if (AcctIsAdmin())
	{
        $fStart = microtime(true);
		call_user_func($callback);
        DebugString($callback.DebugGetStopWatchDisplay($fStart));
	}
	SwitchToSess();
}

function AcctGetEmailFromBlogUri($strUri)
{
	$iPos = strpos($strUri, '/', 1);
	$strName = substr($strUri, 1, $iPos - 1);
	if ($strName == 'woody' || $strName == 'chishin' || $strName == 'tangli')
	{
	    return UrlGetEmail($strName);
	}
	return ADMIN_EMAIL;
}

function AcctGetMemberIdFromBlogUri($strUri)
{
	$strEmail = AcctGetEmailFromBlogUri($strUri);
	return SqlGetIdByEmail($strEmail);           		             
}

class AcctStart
{
    var $strLoginId;
    var $strMemberId;
    
    function AcctStart($bMustLogin = true) 
    {
    	if ($bMustLogin)
    	{
    		$this->strLoginId = AcctAuth();
    	}
    	else
    	{
    		$this->strLoginId = AcctNoAuth();
    	}

	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		$this->strMemberId = SqlGetIdByEmail($strEmail); 
	   	}
	   	else
	   	{
	   		$this->strMemberId = $this->strLoginId;
	   	}
    }
    
    function GetLoginId()
    {
    	return $this->strLoginId;
    }
    
    function GetMemberId()
    {
    	return $this->strMemberId;
    }

    function IsAdmin()
    {
	   	return AcctIsAdmin($this->strLoginId);
    }
}

class TitleAcctStart extends AcctStart
{
	var $strTitle;
	var $strQuery;
	
    function TitleAcctStart($arMustLoginTitle = false) 
    {
    	$this->strTitle = UrlGetTitle();
    	if ($arMustLoginTitle)
    	{
    		$bMustLogin = in_array($this->strTitle, $arMustLoginTitle) ? true : false;
    	}
    	else
    	{
    		$bMustLogin = true;
    	}
        parent::AcctStart($bMustLogin);
        
        $this->strQuery = UrlGetQueryValue($this->strTitle);
    }
    
    function GetTitle()
    {
    	return $this->strTitle;
    }
    
    function GetQuery()
    {
    	return $this->strQuery;
    }
}

?>
