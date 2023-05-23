<?php
require_once('url.php');
require_once('debug.php');
require_once('email.php');
require_once('httplink.php');
require_once('ui/htmlelement.php');
require_once('class/year_month_day.php');

require_once('sql/sqlvisitor.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlmember.php');
require_once('internallink.php');

require_once('_private.php');
require_once('sql/_sqlcommon.php');

define('DB_DATABASE', 'n5gl0n39mnyn183l_camman');

define('TABLE_FUND_EST', 'fundest');
define('TABLE_FUND_PURCHASE', 'fundpurchase');
define('TABLE_MEMBER', 'member');
define('TABLE_PAGE', 'page');
define('TABLE_PAGE_COMMENT', 'pagecomment');
define('TABLE_PROFILE', 'profile');
define('TABLE_STOCK_DIVIDEND', 'stockdividend');
define('TABLE_STOCK_GROUP', 'stockgroup');
define('TABLE_STOCK_GROUP_ITEM', 'stockgroupitem');
define('TABLE_STOCK_SPLIT', 'stocksplit');
define('TABLE_VISITOR', 'visitor');

function die_mysql_error($str)
{
	$str .= ' '.mysql_error();
    DebugString($str);
    die($str);
}

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
		die_mysql_error('Unable to select database');
	}
}

function SqlCleanString($str) 
{
	$str = UrlCleanString($str);
	return mysql_real_escape_string($str);
}

function _errorHandler($errno, $errstr, $errfile, $errline)
{
	if ($errfile == '/php/class/ini_file.php')	return;
	
	$strFileName = DebugGetPathName('errorhandler.txt');
    if (file_exists($strFileName))
    {
    	$str = file_get_contents($strFileName);
    	$ar = explode(',', $str);
//    	$strError = $ar[0];
    	$iCount = (GetNowTick() - filemtime($strFileName) < 100) ? intval($ar[1]) + 1 : 1;
    }
    else	$iCount = 1;
	
    $strCount = strval($iCount);
 	file_put_contents($strFileName, $errno.','.$strCount);
   	if ($iCount <= 5)
   	{
   		$strSubject = ($errno == '1024') ? '调试消息' : "PHP错误: [$errno]";
   		$str = $errstr.'<br />位于'.$errfile.'第'.$errline.'行';
   		$strDebug = "$strSubject $str ($strCount)";
    
   		$str .= '<br />'.GetExternalLink(UrlGetServer().UrlGetCur());
//   		if (isset($_SESSION['SESS_ID']))		$str .= '<br />'.GetMemberLink($_SESSION['SESS_ID']);	// need MySQL successful

		$strIp = UrlGetIp();
		$str .= '<br />'.GetVisitorLink($strIp);
   		if (EmailHtml(ADMIN_EMAIL, $strSubject.' '.$strIp, $str) == false)	$strDebug .= ' mail failed too';
   		DebugString($strDebug);
   	}
}

function _ConnectDatabase()
{
	$link = mysql_connect('mysql', 'n5gl0n39mnyn183l_woody', DB_PASSWORD);	// Connect to mysql server
	if (!$link) 
	{
		return false;
	}
	mysql_set_charset('utf8', $link);

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
