<?php
//require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('sql.php');
require_once('ui/table.php');

//require_once('sql/sqlmember.php');
//require_once('sql/sqlblog.php');
//require_once('sql/sqlvisitor.php');
require_once('sql/sqlipaddress.php');
require_once('sql/sqlstockgroup.php');
require_once('sql/sqlfundpurchase.php');

function _checkVisitor($sql, $page_sql, $visitor_sql, $strMemberId)
{
	$strId = $sql->GetId();
    if ($strBlogId = $page_sql->GetKeyId())
    {
    	$visitor_sql->InsertVisitor($strBlogId, $strId);
    }
    
	$iCount = $visitor_sql->CountBySrc($strId);
	if ($iCount >= 500)
	{
		$iPageCount = $visitor_sql->CountUniqueDst($strId);
		$strDebug = '访问次数: '.strval($iCount).' 不同页面数: '.strval($iPageCount);
		if ($strMemberId)								$strDebug .= ' logined!';
		if ($sql->GetStatus() == IP_STATUS_CRAWL)		$strDebug .= ' 已标注的老爬虫';
		else
		{
			if ($iPageCount >= ($iCount / 100))
			{
				$strDebug .= ' 疑似爬虫';
			}
			else
			{
				$strDebug .= '新标注爬虫';
				$sql->SetStatus(IP_STATUS_CRAWL);
			}
		}
		trigger_error($strDebug);
		$sql->AddVisit($iCount);
		$visitor_sql->DeleteBySrc($strId);        
	}
}

class Account
{
    var $strMemberId = false;
    
    var $strLoginEmail = false;

    var $ip_sql;
    var $page_sql;
    var $visitor_sql;

    var $bAllowCurl;
    
    function Account() 
    {
    	session_start();
    	SqlConnectDatabase();

	    $this->ip_sql = new IpSql(UrlGetIp());
	    $this->page_sql = new PageSql(UrlGetUri());
	    $this->visitor_sql = new VisitorSql(TABLE_VISITOR, 'dst', 'src');
	    _checkVisitor($this->ip_sql, $this->page_sql, $this->visitor_sql, $this->GetLoginId());
    	$this->bAllowCurl = ($this->ip_sql->GetStatus() != IP_STATUS_NORMAL) ? false : true;

	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		if (filter_var_email($strEmail))
	   		{
	   			$this->strMemberId = SqlGetIdByEmail($strEmail);
	   		}
	   	}
    }
    
    function GetIpSql()
    {
    	return $this->ip_sql;
    }
    
    function GetPageSql()
    {
    	return $this->page_sql;
    }
    
    function GetVisitorSql()
    {
    	return $this->visitor_sql;
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

    function AllowCurl()
    {
    	return $this->bAllowCurl;
    }
    
    function Back()
    {
    	SwitchToSess();
    }

    function IsAdmin()
    {
    	if ($this->GetLoginEmail() == ADMIN_EMAIL)
    	{
    		return true;
    	}
    	return false;
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

    function AdminProcess()
    {
    	DebugString('Empty Admin Process');
    }
    
    function AdminRun()
    {
    	if ($this->IsAdmin())
    	{
    		$this->AdminProcess();
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
