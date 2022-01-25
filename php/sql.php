<?php
define('DB_DATABASE', 'camman');

define('TABLE_CALIBRATION_HISTORY', 'calibrationhistory');
define('TABLE_COMMON_PHRASE', 'commonphrase');
define('TABLE_DOW_JONES', 'dowjones');
define('TABLE_FUND_EST', 'fundest');
define('TABLE_FUND_PURCHASE', 'fundpurchase');
define('TABLE_HOLDINGS', 'holdings');
define('TABLE_IP', 'ip');
define('TABLE_MEMBER', 'member');
define('TABLE_NETVALUE_HISTORY', 'netvaluehistory');
define('TABLE_PAGE', 'page');
define('TABLE_PAGE_COMMENT', 'pagecomment');
define('TABLE_PRIME_NUMBER', 'primenumber');
define('TABLE_PROFILE', 'profile');
define('TABLE_STOCK', 'stock');
define('TABLE_STOCK_DIVIDEND', 'stockdividend');
define('TABLE_STOCK_GROUP', 'stockgroup');
define('TABLE_STOCK_GROUP_ITEM', 'stockgroupitem');
define('TABLE_STOCK_HISTORY', 'stockhistory');
define('TABLE_STOCK_SPLIT', 'stocksplit');
define('TABLE_VISITOR', 'visitor');

require_once('debug.php');
require_once('email.php');
require_once('csvfile.php');
require_once('_private.php');
require_once('class/year_month_day.php');
require_once('sql/_sqlcommon.php');

function die_mysql_error($strDie)
{
    dieDebugString($strDie.' '.mysql_error());
}

/*
function SqlWhereFromUrlQuery($strQuery)
{
    if ($strQuery == false)     return false;
    
	$arVal = array();
    $arQuery = explode('&', $strQuery);
    foreach ($arQuery as $str)
    {
        $ar = explode('=', $str);
        $arVal[$ar[0]] = $ar[1];
    }
    return _SqlBuildWhereAndArray($arVal);
}
*/

function SqlDieByQuery($strQry, $strDie)
{
	if ($result = @mysql_query($strQry)) 
	{
		return true;
	}
	else
	{
	    die_mysql_error($strDie);
	}
	return false;
}

function SqlGetTableData($strTableName, $strWhere = false, $strOrder = false, $strLimit = false)
{
	$strQry = 'SELECT * FROM '.$strTableName._SqlAddWhere($strWhere)._SqlAddOrder($strOrder)._SqlAddLimit($strLimit);
	if ($result = mysql_query($strQry))
	{
	    if (mysql_num_rows($result) > 0) 
	    {
	        return $result;
	    }
	}
	else
	{
	    die_mysql_error($strTableName.' query data by '.$strQry.' failed');
	}
	return false;
}

function SqlGetSingleTableData($strTableName, $strWhere = false, $strOrder = false)
{
	$strQry = 'SELECT * FROM '.$strTableName._SqlAddWhere($strWhere)._SqlAddOrder($strOrder)._SqlAddLimit('1');
	if ($result = mysql_query($strQry)) 
	{
	    if (mysql_num_rows($result) == 1) 
	    {
	        $record = mysql_fetch_assoc($result);
	        @mysql_free_result($result);
	        return $record;
	    }
	}
	else
	{
	    die_mysql_error($strTableName.' query single data by '.$strQry.' failed');
	}
	return false;
}

function SqlGetTableDataById($strTableName, $strId)
{
	if ($strId)
	{
		return SqlGetSingleTableData($strTableName, _SqlBuildWhere_id($strId));
	}
	return false;
}

function SqlDeleteTableData($strTableName, $strWhere, $strLimit = false)
{
    if ($strWhere)
    {
        $strQry = 'DELETE FROM '.$strTableName._SqlAddWhere($strWhere)._SqlAddLimit($strLimit);
        return SqlDieByQuery($strQry, $strTableName.' delete table data by '.$strQry.' failed');
    }
    return false;
}

function SqlDeleteTableDataById($strTableName, $strId)
{
    return SqlDeleteTableData($strTableName, _SqlBuildWhere_id($strId), '1');
}

function SqlCountTableData($strTableName, $strWhere = false)
{
	$strQry = "SELECT count(*) as total FROM $strTableName"._SqlAddWhere($strWhere);
	if ($result = mysql_query($strQry))
	{
		$record = mysql_fetch_array($result);
		return intval($record['total']);
	}
	return 0;
}

function SqlCreateDatabase($strDb)
{
	$str = "CREATE DATABASE `$strDb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	SqlDieByQuery($str, 'Create database failed');
	
	$db = mysql_select_db($strDb);		// Select database again
	if (!$db) 
	{
		dieDebugString('Unable to select database');
	}
}

function SqlCleanString($str) 
{
	$str = UrlCleanString($str);
	return mysql_real_escape_string($str);
}

class ErrorHandlerFile extends DebugCsvFile
{
	var $strError = false;
	var $iCount = 0;
	
    function ErrorHandlerFile() 
    {
        parent::DebugCsvFile('errorhandler');
    }

    public function OnLineArray($arWord)
    {
    	if (count($arWord) == 2)
    	{
    		// $errno,count
    		$this->strError = $arWord[0];
    		$this->iCount  = intval($arWord[1]);
    	}
    }
    
    function OnError($errno)
    {
    	$bCount = ($this->GetModifiedSeconds() < 100) ? true : false;
    	
    	$this->Read();
    	$iCount = $this->iCount;
//    	if ($errno == $this->strError)
    	if ($bCount)
    	{
   			$iCount ++;
    	}
    	else
    	{
    		$iCount = 1;
    	}
    	
   		$this->Write($errno, strval($iCount));
   		$this->Close();
    	return $iCount;
    }
}

function _errorHandler($errno, $errstr, $errfile, $errline)
{
	if ($errfile == '/php/class/ini_file.php')	return;
	
	$bDebug = (intval($errno) == 1024) ? true : false;
   	$csv = new ErrorHandlerFile();
   	$iCount = $csv->OnError($errno);
   	if ($iCount <= 5 || $bDebug)
   	{
   		$strSubject = $bDebug ? '调试消息' : "PHP错误: [$errno]";
   		$str =  $errstr.'<br />位于'.$errfile.'第'.$errline.'行';
   		$strDebug = $strSubject.' '.$str.' ('.strval($iCount).')';
    
   		$str .= '<br />'.GetCurLink();
//   		if (isset($_SESSION['SESS_ID']))		$str .= '<br />'.GetMemberLink($_SESSION['SESS_ID']);	// need MySQL successful

		$strIp = UrlGetIp();
   		$str .= '<br />'.GetVisitorLink($strIp);
   		if (EmailHtml(ADMIN_EMAIL, $strSubject.' '.$strIp, $str) == false)
   		{
   			$strDebug .= ' mail failed too';
   		}
   		DebugString($strDebug);
   	}
//	DebugVal($iCount, $errno.' _errorHandler');
}

function _ConnectDatabase()
{
	$link = mysql_connect('mysql', 'woody', DB_PASSWORD);	// Connect to mysql server
	if (!$link) 
	{
		return false;
	}
	
	$db = mysql_select_db(DB_DATABASE);		// Select database
	if (!$db) 
	{
	    DebugString('No database yet, create it');
		SqlCreateDatabase(DB_DATABASE);
	}
	return true;
}

function SqlConnectDatabase()
{
	// 设置用户定义的错误处理函数
	error_reporting(E_ALL);
	set_error_handler('_errorHandler');
/*	
	if (UrlGetIp() != '222.125.92.104')
	{
		die('Failed to connect to server');
	}
*/
	if (_ConnectDatabase() == false)
	{
		$str = 'Failed to connect to server: '.mysql_error();
		die($str);
	}
}

?>
