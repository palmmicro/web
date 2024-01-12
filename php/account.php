<?php
require_once('switch.php');
require_once('sql.php');
require_once('ui/table.php');

require_once('sql/sqlipaddress.php');
require_once('sql/sqlstocksymbol.php');
require_once('sql/sqlstockgroup.php');
require_once('sql/sqlfundpurchase.php');

define('DISP_ALL_US', 'All');
define('DISP_EDIT_US', 'Edit');
define('DISP_NEW_US', 'New');

define('DISP_ALL_CN', '全部');
define('DISP_EDIT_CN', '修改');
define('DISP_NEW_CN', '新建');

function GetAllDisplay($bChinese = true)
{
	return $bChinese ? DISP_ALL_CN : DISP_ALL_US;
}

class Account
{
    var $strMemberId = false;
    var $strPageId;
    
    var $strLoginEmail = false;

    var $ip_sql;
    var $page_sql;
    var $visitor_sql;

    var $bAllowCurl;
    
    public function __construct() 
    {
    	session_start();
    	SqlConnectDatabase();

	    $strIp = UrlGetIp();
	    $this->ip_sql = new IpSql();
	    $strStatus = $this->ip_sql->GetStatus($strIp);
	    if ($strStatus == IP_STATUS_MALICIOUS)	die('403 Forbidden');
//	    if ($strStatus != IP_STATUS_NORMAL)	die('401 Unauthorized');
    	$this->bAllowCurl = ($strStatus != IP_STATUS_NORMAL) ? false : true;

		$this->ip_sql->InsertIp($strIp);

	    $strUri = UrlGetUri();
	    $this->page_sql = new PageSql();
   		$this->page_sql->InsertKey($strUri);
	    
	    $this->visitor_sql = new VisitorSql();
	    $strId = GetIpId($strIp);
	    if ($this->strPageId = $this->GetPageId($strUri))	$this->visitor_sql->InsertVisitor($this->strPageId, $strId);
    
	    $iCount = $this->visitor_sql->CountBySrc($strId);
	    if ($iCount >= 1000)
	    {
	    	$iPageCount = $this->visitor_sql->CountUniqueDst($strId);
	    	$strDebug = '访问次数: '.strval($iCount).'<br />不同页面数: '.strval($iPageCount).'<br />';
	    	if ($this->GetLoginId())						$strDebug .= 'logined!<br />';
	    	if ($strStatus == IP_STATUS_CRAWLER)			$strDebug .= '已标注的老爬虫';
	    	else
	    	{
	    		if ($iPageCount >= ($iCount / 100))		$strDebug .= '疑似爬虫';
	    		else
	    		{
	    			$strDebug .= '新标注爬虫';
	    			$this->SetCrawler($strIp);
	    			$strStatus = IP_STATUS_CRAWLER;
	    		}
	    	}
	    	trigger_error($strDebug);
	    	$this->ip_sql->AddVisit($strIp, $iCount);
	    	$this->visitor_sql->DeleteBySrc($strId);        
	    }

	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		if (filter_var_email($strEmail))		$this->strMemberId = SqlGetIdByEmail($strEmail);
	   	}
		InitGlobalStockSql();
    }

    function SetCrawler($strIp)
    {
    	return $this->ip_sql->SetStatus($strIp, IP_STATUS_CRAWLER);
    }
    
    function SetMalicious($strIp)
    {
    	return $this->ip_sql->SetStatus($strIp, IP_STATUS_MALICIOUS);
    }
    
    function GetIpSql()
    {
    	return $this->ip_sql;
    }
    
    function GetPageUri($strPageId)
    {
    	return $this->page_sql->GetPageUri($strPageId);
    }
    
    function GetPageId($strPageUri = false)
    {
    	return $strPageUri ? $this->page_sql->GetId($strPageUri) : $this->strPageId;
    }
    
    function GetPageSql()
    {
    	return $this->page_sql;
    }
    
    function GetVisitorSql()
    {
    	return $this->visitor_sql;
    }
    
    function Auth()
    {
    	if ($this->GetLoginId() == false) 
    	{
    		SwitchSetSess();
    		SwitchTo('/account/login');
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
    	return $this->GetWhoseDisplay(false, $bChinese).$strAll;
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
    
    function IsAdmin()
    {
    	if ($this->GetLoginEmail() == ADMIN_EMAIL)
    	{
    		return true;
    	}
    	return false;
    }
    
    public function AdminProcess()
    {
    	DebugString('Empty Admin Process');
    }
    
    function AdminRun()
    {
    	if ($this->IsAdmin())
    	{
    		$fStart = microtime(true);
    		$this->AdminProcess();
    		DebugString(DebugGetStopWatchDisplay($fStart));
    	}
    	SwitchToSess();
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
    	SwitchToSess();
    }
}

class TitleAccount extends Account
{
	var $strPage;
	var $strQuery;
	
    var $iStart;
    var $iNum;
    
    public function __construct($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::__construct();
    	$this->strPage = UrlGetPage();
    	if ($arLoginTitle)
    	{
    		if (($arLoginTitle === true) || in_array($this->strPage, $arLoginTitle))		$this->Auth();
    	}
   		
   		$this->iStart = UrlGetQueryInt('start');
   		$this->iNum = UrlGetQueryInt('num', DEFAULT_PAGE_NUM);
   		if (($this->iStart != 0) && ($this->iNum != 0))							  			$this->Auth();
   		
        $this->strQuery = UrlGetQueryValue($strQueryItem ? $strQueryItem : $this->strPage);
    }
    
    function GetPage()
    {
    	return $this->strPage;
    }
    
    // photo2006 -> 2006
    function GetPageYear()
    {
    	return substr($this->strPage, -4, 4);
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
    
    function GetStartNumDisplay($bChinese = true)
    {
   		if (($this->iStart == 0) && ($this->iNum == 0))	$str = GetAllDisplay($bChinese);
   		else 													$str = strval($this->iStart + 1).'-'.strval($this->iStart + $this->iNum); 
    	return "($str)";
    }
}

?>
