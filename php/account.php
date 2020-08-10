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

function AcctCountBlogVisitor($sql)
{
    return SqlCountVisitor(VISITOR_TABLE, $sql->GetKeyId());
}

function AcctDeleteBlogVisitorByIp($sql)
{
    if ($strId = $sql->GetKeyId())
    {
        $iCount = AcctCountBlogVisitor($sql);
		$sql->AddVisit($iCount);
        SqlDeleteVisitor(VISITOR_TABLE, $strId);
    }
    if ($sql->GetStatus() == IP_STATUS_BLOCKED)		$sql->SetStatus(IP_STATUS_NORMAL);
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
		
		$sql = new IpSql($strIp);
		$sql->IncLogin();
    }
    return $strMemberId;
}

function AcctLogout()
{
	// Unset the variables stored in session
	unset($_SESSION['SESS_ID']);
}

function AcctGetBlogVisitor($sql, $iStart = 0, $iNum = 0)
{
    return SqlGetVisitor(VISITOR_TABLE, $sql->GetKeyId(), $iStart, $iNum);
}

function AcctGetSpiderPageCount($sql)
{
    $ar = array();
	if ($result = AcctGetBlogVisitor($sql)) 
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

function _onBlockedIp($sql)
{
    mysql_close();
    die('Please contact support@palmmicro.com to unblock your IP address '.$sql->GetKey());
}

function _checkSearchEngineSpider($sql, $iCount, $iPageCount, $strDebug)
{
    if ($arInfo = IpInfoIpLookUp($sql))
    {
    	if (isset($arInfo['org']))
    	{
    		$strOrg = $arInfo['org'];
    		if (strstr_array($strOrg, array('microsoft', 'yahoo', 'yandex')))
    		{
    			trigger_error('Known company: '.$strOrg);
    			return true;
    		}
    		$strDebug .= '<br />'.$strOrg;
    	}
    
    	if (isset($arInfo['hostname']))
    	{
    		$strDns = $arInfo['hostname'];
    		if (strstr_array($strDns, array('baidu', 'bytedance', 'google', 'msn', 'sogou', 'yahoo', 'yandex')))
    		{
    			trigger_error('Known DNS: '.$strDns);
    			return true;
    		}
    		$strDebug .= '<br />'.$strDns;
    	}
    }
   	
    if ($iPageCount >= 10)
    {
    	trigger_error('Unknown spider<br />'.$strDebug);
    	return true;
    }
    
	trigger_error('Blocked spider<br />'.$strDebug);
	$sql->SetStatus(IP_STATUS_BLOCKED);
	_onBlockedIp($sql);
    return false;
}

function AcctGetBlogId()
{
	$sql = new PageSql(UrlGetUri());
	return $sql->GetKeyId();
}

function _checkVisitor($sql, $strMemberId)
{
    SqlCreateVisitorTable(VISITOR_TABLE);
    if ($strBlogId = AcctGetBlogId())
    {
    	SqlInsertVisitor(VISITOR_TABLE, $strBlogId, $sql->GetKeyId());
    }
    if ($sql->GetStatus() == IP_STATUS_BLOCKED)		_onBlockedIp($sql);
    
	$iCount = AcctCountBlogVisitor($sql);
	if ($iCount >= 1000)
	{
		$iPageCount = AcctGetSpiderPageCount($sql);
		$strDebug = strval($iCount).' '.strval($iPageCount);
		if ($strMemberId)
		{
    		trigger_error('Possible logined spider: '.$strDebug);
	        AcctDeleteBlogVisitorByIp($sql);
	    }
	    else
	    {
	    	if (_checkSearchEngineSpider($sql, $iCount, $iPageCount, $strDebug))
	    	{
	    		AcctDeleteBlogVisitorByIp($sql);
	    	}
	    }
	}
}

class Account
{
    var $strMemberId = false;
    
    var $strLoginEmail = false;

    var $ip_sql;

    var $bAllowCurl;
    
    function Account() 
    {
    	session_start();
    	SqlConnectDatabase();

	    $this->ip_sql = new IpSql(UrlGetIp());
	    _checkVisitor($this->ip_sql, $this->GetLoginId());
    	$this->bAllowCurl = ($this->ip_sql->GetStatus() == IP_STATUS_CRAWL) ? false : true;

	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		if (filter_var_email($strEmail))
	   		{
	   			$this->strMemberId = SqlGetIdByEmail($strEmail);
	   		}
	   	}
    }
    
    function _switchToLogin()
    {
    	SwitchSetSess();
    	SwitchTo('/account/login');
    }

    function Auth()
    {
    	if ($this->GetLoginId() == false) 
    	{
    		$this->_switchToLogin();
    	}
    }
    
    function AuthAdmin()
    {
    	if ($this->IsAdmin() == false) 
    	{
    		$this->_switchToLogin();
    	}
    }
    
    function GetWhoseDisplay($strMemberId = false, $bChinese = true)
    {
    	if ($strMemberId == false)		$strMemberId = $this->GetMemberId();
    	
    	if ($strMemberId == $this->GetLoginId())
    	{
    		$str = $bChinese ? '我' : 'My';
    	}
    	else
    	{
    		if (($str = SqlGetNameByMemberId($strMemberId)) == false)
    		{
    			$str = SqlGetEmailById($strMemberId);
    		}
    	}
    	return $str.($bChinese ? '的' : ' ');
    }
    
    function GetWhoseAllDisplay($bChinese = true)
    {
     	$strAll = $bChinese ? DISP_ALL_CN : ' '.DISP_ALL_US.' ';
    	return $this->GetWhoseDisplay($bChinese).$strAll;
    }
    
    function GetLoginId()
    {
    	// Check whether the session variable SESS_ID is present or not
    	$strMemberId = isset($_SESSION['SESS_ID']) ? $_SESSION['SESS_ID'] : false;
    	if ($strMemberId)
    	{
    		if (trim($strMemberId) == '')	$strMemberId = false;
    	}
    	return $strMemberId;	
    }
    
    function GetMemberId()
    {
    	if ($this->strMemberId)	return $this->strMemberId;
    	return $this->GetLoginId();
    }
    
    function GetLoginEmail()
    {
    	if (($strLoginId = $this->GetLoginId()) == false)	return false;
    	
    	if ($this->strLoginEmail == false)
    	{
    		$this->strLoginEmail = SqlGetEmailById($strLoginId);
    	}
    	return $this->strLoginEmail;
	}

    function IsReadOnly()
    {
    	if ($this->strMemberId)	return ($this->GetLoginId() == $this->strMemberId) ? false : true;
    	return false;
    }

    function IsAdmin()
    {
    	if ($this->GetLoginEmail() == ADMIN_EMAIL)
    	{
    		return true;
    	}
    	return false;
    }
    
    function AllowCurl()
    {
    	return $this->bAllowCurl;
    }
    
    function Back()
    {
    	SwitchToSess();
    }

    function AdminCommand($callback)
    {
    	if ($this->IsAdmin())
    	{
    		$fStart = microtime(true);
    		call_user_func($callback);
    		DebugString($callback.DebugGetStopWatchDisplay($fStart));
    	}
    	$this->Back();
    }

    function Process()
    {
    	DebugString('Empty Process');
    }
    
    function Run()
    {
    	if ($strLoginId = $this->GetLoginId())
    	{
    		$this->Process($strLoginId);
    	}
    	$this->Back();
    }
}

function AcctIsAdmin()
{
   	global $acct;
	return $acct->IsAdmin();
}

function AcctIsLogin()
{
   	global $acct;
	return $acct->GetLoginId();
}

class DataAccount extends Account
{
    var $iStart;
    var $iNum;
    
    function DataAccount() 
    {
        parent::Account();
        
   		$this->iStart = UrlGetQueryInt('start');
   		$this->iNum = UrlGetQueryInt('num', 100);
   		if (($this->iStart != 0) && ($this->iNum != 0))
   		{
   			$this->Auth();
   		}
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

class TitleAccount extends DataAccount
{
	var $strTitle;
	var $strQuery;
	
    function TitleAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::DataAccount();
    	$this->strTitle = UrlGetTitle();
    	if ($arLoginTitle)
    	{
    		if (in_array($this->strTitle, $arLoginTitle))
    		{
    			$this->Auth();
    		}
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
}

?>
