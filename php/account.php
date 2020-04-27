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

function AcctSessionStart()
{
	session_start();
    SqlConnectDatabase();

    SqlCreateVisitorTable(VISITOR_TABLE);
	$strIp = UrlGetIp();
	
	$sql = new IpSql($strIp);
    if ($strBlogId = AcctGetBlogId())
    {
       	SqlInsertVisitor(VISITOR_TABLE, $strBlogId, $sql->GetKeyId());
    }
    if ($sql->GetStatus() == IP_STATUS_BLOCKED)		_onBlockedIp($sql);
    
	$strMemberId = AcctIsLogin();
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
    return $strMemberId;	
}

class AcctStart
{
    var $strLoginId;
    var $strMemberId;
    
    var $iStart;
    var $iNum;
    
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
        
   		$this->iStart = UrlGetQueryInt('start');
   		$this->iNum = UrlGetQueryInt('num', 100);
   		if (($this->iStart != 0) && ($this->iNum != 0))
   		{
   			$this->Auth();
   		}
    }
    
    function _switchToLogin()
    {
    	SwitchSetSess();
    	SwitchTo('/account/login');
    }

    function Auth()
    {
    	if ($this->strLoginId == false) 
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
    
    function GetStart()
    {
    	return $this->iStart;
    }
    
    function GetNum()
    {
    	return $this->iNum;
    }
}

function AcctNoAuth()
{
   	$acct = new AcctStart();
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
