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
require_once('sql/sqlstocksymbol.php');
require_once('sql/sqlstockgroup.php');
require_once('sql/sqlfundpurchase.php');

function _checkVisitor($strIp, $sql, $visitor_sql, $strBlogId, $strMemberId)
{
	$strId = GetIpId($strIp);
    if ($strBlogId)
    {
    	$visitor_sql->InsertVisitor($strBlogId, $strId);
    }
    
	$iCount = $visitor_sql->CountBySrc($strId);
	if ($iCount >= 1000)
	{
		$iPageCount = $visitor_sql->CountUniqueDst($strId);
		$strDebug = '访问次数: '.strval($iCount).'<br />不同页面数: '.strval($iPageCount).'<br />';
		if ($strMemberId)								$strDebug .= 'logined!<br />';
		if ($sql->GetStatus($strIp) == IP_STATUS_CRAWLER)		$strDebug .= '已标注的老爬虫';
		else
		{
			if ($iPageCount >= ($iCount / 100))
			{
				$strDebug .= '疑似爬虫';
			}
			else
			{
				$strDebug .= '新标注爬虫';
				$sql->SetStatus($strIp, IP_STATUS_CRAWLER);
			}
		}
		trigger_error($strDebug);
		$sql->AddVisit($strIp, $iCount);
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

	    $strIp = UrlGetIp();
	    $this->ip_sql = new IpSql();
   		$this->ip_sql->InsertIp($strIp);

	    $strUri = UrlGetUri();
	    $this->page_sql = new PageSql();
   		$this->page_sql->InsertKey($strUri);
	    
	    $this->visitor_sql = new VisitorSql();
	    _checkVisitor($strIp, 	$this->ip_sql, $this->visitor_sql, $this->GetPageId($strUri), $this->GetLoginId());
    	$this->bAllowCurl = ($this->ip_sql->GetStatus($strIp) != IP_STATUS_NORMAL) ? false : true;

	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		if (filter_var_email($strEmail))
	   		{
	   			$this->strMemberId = SqlGetIdByEmail($strEmail);
	   		}
	   	}

		InitGlobalStockSql();
    }

    function SetCrawler($strIp)
    {
    	return $this->ip_sql->SetStatus($strIp, IP_STATUS_CRAWLER);
    }
    
    function GetIpSql()
    {
    	return $this->ip_sql;
    }
    
    function GetPageUri($strPageId)
    {
    	return $this->page_sql->GetKey($strPageId);
    }
    
    function GetPageId($strPageUri)
    {
    	return $this->page_sql->GetId($strPageUri);
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

    public function Process($strLoginId)
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

class TitleAccount extends Account
{
	var $strTitle;
	var $strQuery;
	
    var $iStart;
    var $iNum;
    
    function TitleAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::Account();
    	$this->strTitle = UrlGetTitle();
    	if ($arLoginTitle)
    	{
    		if (($arLoginTitle === true) || in_array($this->strTitle, $arLoginTitle))
    		{
    			$this->Auth();
    		}
    	}
   		
   		$this->iStart = UrlGetQueryInt('start');
   		$this->iNum = UrlGetQueryInt('num', 100);
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
