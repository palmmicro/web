<?php
//require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('sql.php');
require_once('iplookup.php');
require_once('ui/table.php');

//require_once('sql/sqlmember.php');
//require_once('sql/sqlblog.php');
//require_once('sql/sqlvisitor.php');
require_once('sql/sqlstockgroup.php');
require_once('sql/sqlfundpurchase.php');

function AcctCountBlogVisitor($strIp)
{
   	$sql = new IpSql();
    return SqlCountVisitor(VISITOR_TABLE, $sql->GetId($strIp));
}

function AcctDeleteBlogVisitorByIp($strIp)
{
   	$sql = new IpSql();
    if ($strId = $sql->GetId($strIp))
    {
        $iCount = AcctCountBlogVisitor($strIp);
//        SqlAddIpVisit($strIp, $iCount);
		$sql->AddVisit($strIp, $iCount);
        SqlDeleteVisitor(VISITOR_TABLE, $strId);
    }
    if ($sql->GetStatus($strIp) == IP_STATUS_BLOCKED)		$sql->SetStatus($strIp, IP_STATUS_NORMAL);
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
		
		$strIp = UrlGetIp();
		SqlUpdateLoginField($strEmail, $strIp);
		
		$sql = new IpSql();
		$sql->IncLogin($strIp);
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

function AcctNoAdv($strLoginId = false)
{
    if (AcctGetEmail($strLoginId) == WOODY_EMAIL)
	{
	    return true;
	}
	return false;
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

function AcctGetBlogVisitor($strIp, $iStart = 0, $iNum = 0)
{
   	$sql = new IpSql();
    return SqlGetVisitor(VISITOR_TABLE, $sql->GetId($strIp), $iStart, $iNum);
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

function _onBlockedIp($strIp)
{
    die('Please contact support@palmmicro.com to unblock your IP address '.$strIp);
}

function _checkSearchEngineSpider($sql, $strIp, $iCount, $iPageCount, $strDebug)
{
    $arIpInfo = IpInfoIpLookUp($strIp);
    if (isset($arIpInfo['org']))
    {
    	$strOrg = $arIpInfo['org'];
    	if (strstr_array($strOrg, array('microsoft', 'yahoo', 'yandex')))
    	{
    		trigger_error('Known company: '.$strOrg);
    		return true;
    	}
    	$strDebug .= '<br />'.$strOrg;
    }
    
    if (isset($arIpInfo['hostname']))
    {
    	$strDns = $arIpInfo['hostname'];
   		if (strstr_array($strDns, array('baidu', 'bytedance', 'google', 'msn', 'sogou', 'yahoo', 'yandex')))
   		{
   			trigger_error('Known DNS: '.$strDns);
   			return true;
   		}
    	$strDebug .= '<br />'.$strDns;
   	}
   	
    if ($iPageCount >= 10)
    {
    	trigger_error('Unknown spider<br />'.$strDebug);
    	return true;
    }
    
	trigger_error('Blocked spider<br />'.$strDebug);
	$sql->SetStatus($strIp, IP_STATUS_BLOCKED);
	_onBlockedIp($strIp);
    return false;
}

function AcctGetBlogId()
{
    $strUri = UrlGetUri();	                        // /woody/blog/entertainment/20140615cn.php
	$sql = new PageSql();
	$sql->InsertKey($strUri);
	return $sql->GetId($strUri);
}

function AcctSessionStart()
{
	session_start();
    SqlConnectDatabase();

    SqlCreateVisitorTable(VISITOR_TABLE);
	$strIp = UrlGetIp();
	
	$sql = new IpSql();
	$sql->InsertIp($strIp);
    if ($strBlogId = AcctGetBlogId())
    {
       	SqlInsertVisitor(VISITOR_TABLE, $strBlogId, $sql->GetId($strIp));
    }
    if ($sql->GetStatus($strIp) == IP_STATUS_BLOCKED)		_onBlockedIp($strIp);
    
	$strMemberId = AcctIsLogin();
	$iCount = AcctCountBlogVisitor($strIp);
	if ($iCount >= 1000)
	{
		$iPageCount = AcctGetSpiderPageCount($strIp);
		$strDebug = strval($iCount).' '.strval($iPageCount);
		if ($strMemberId)
		{
    		trigger_error('Possible logined spider: '.$strDebug);
	        AcctDeleteBlogVisitorByIp($strIp);
	    }
	    else
	    {
	    	if (_checkSearchEngineSpider($sql, $strIp, $iCount, $iPageCount, $strDebug))
	    	{
	    		AcctDeleteBlogVisitorByIp($strIp);
	    	}
/*	    	else
	    	{
	    		AcctSwitchToLogin();
	    	}*/
	    }
	}
    return $strMemberId;	
}

class AcctStart
{
    var $strLoginId;
    var $strMemberId;
    
    function AcctStart() 
    {
   		$this->strLoginId = AcctSessionStart();
	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		$this->strMemberId = SqlGetIdByEmail($strEmail); 
	   	}
	   	else
	   	{
	   		$this->strMemberId = $this->strLoginId;
	   	}
    }
    
    function Auth()
    {
    	if ($this->strLoginId == false) 
    	{
    		AcctSwitchToLogin();
    	}
    }
    
    function GetWhoseDisplay($strMemberId = false)
    {
    	if ($strMemberId == false)		$strMemberId = $this->strMemberId;

    	if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
    	{
    		$strName = SqlGetEmailById($strMemberId);
    	}
    	$str = ($strMemberId == $this->strLoginId) ? '我' : $strName;
    	return $str.'的';
    }
    
    function GetWhoseAllDisplay()
    {
    	return $this->GetWhoseDisplay().STOCK_DISP_ALL;
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

    function Back()
    {
    	SwitchToSess();
    }
}

function AcctNoAuth()
{
   	$acct = new AcctStart();
}

function AcctAuth()
{
   	$acct = new AcctStart();
	$acct->Auth();
	return $acct->GetLoginId();
}

function AcctAdminCommand($callback)
{
   	$acct = new AcctStart();
   	if ($acct->IsAdmin())
	{
        $fStart = microtime(true);
		call_user_func($callback);
        DebugString($callback.DebugGetStopWatchDisplay($fStart));
	}
	$acct->Back();
}

class TitleAcctStart extends AcctStart
{
	var $strTitle;
	var $strQuery;
	
    var $iStart;
    var $iNum;
    
    function TitleAcctStart($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::AcctStart();
    	$this->strTitle = UrlGetTitle();
    	if ($arLoginTitle)
    	{
    		if (in_array($this->strTitle, $arLoginTitle))
    		{
    			$this->Auth();
    		}
    	}
        
   		$this->iStart = UrlGetQueryInt('start');
   		$this->iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		if (($this->iStart != 0) && ($this->iNum != 0))
   		{
   			$this->Auth();
   		}
   		
        $this->strQuery = UrlGetQueryValue($strQueryItem ? $strQueryItem : $this->strTitle);
    }
    
    function GetTitle()
    {
    	return $this->strTitle;
    }
    
    function GetQuery()
    {
    	return $this->strQuery;
    }
    
    function GetStart()
    {
    	return $this->iStart;
    }
    
    function GetNum()
    {
    	return $this->iNum;
    }
}

?>
