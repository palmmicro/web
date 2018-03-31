<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'woody');
define('DB_DATABASE', 'camman');

define ('TABLE_BLOG', 'blog');
define ('TABLE_DIVIDEND_PARAMETER', 'dividendparameter');
define ('TABLE_FOREX_HISTORY', 'forexhistory');
define ('TABLE_FUND_HISTORY', 'fundhistory');
define ('TABLE_FUND_PURCHASE', 'fundpurchase');
define ('TABLE_GB2312', 'gb2312');
define ('TABLE_IP_ADDRESS', 'ipaddress');
define ('TABLE_MEMBER', 'member');
define ('TABLE_PROFILE', 'profile');
define ('TABLE_SPIDER_PARAMTER', 'spiderparameter');
define ('TABLE_STOCK', 'stock');
define ('TABLE_STOCK_CALIBRATION', 'stockcalibration');
define ('TABLE_STOCK_GROUP', 'stockgroup');
define ('TABLE_STOCK_GROUP_ITEM', 'stockgroupitem');
define ('TABLE_STOCK_HISTORY', 'stockhistory');
define ('TABLE_WEIXIN', 'weixin');

require_once('debug.php');
require_once('_private.php');
require_once('class/year_month_date.php');
require_once('sql/_sqlcommon.php');

function die_mysql_error($strDie)
{
    $str = $strDie.'--- '.mysql_error();
    DebugString($str);
    die($str);
}

// mysql中用2个单引号代替一个
function str_replace_single_quote($str)
{
    return str_replace("'", "''", $str);
}

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

function SqlQuerySingleRecord($strQry, $strDie)
{
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
	    die_mysql_error($strDie);
	}
	return false;
}

function SqlDropTable($strTableName)
{
    $str = 'DROP TABLE IF EXISTS `camman`.`'
        . $strTableName
        . '`';
	SqlDieByQuery($str, $strTableName.' Drop table failed');
}

function SqlGetTableData($strTableName, $strWhere, $strOrderBy, $strLimit)
{
	$strQry = 'SELECT * FROM '.$strTableName;
	if ($strWhere)       $strQry .= ' WHERE '.$strWhere; 
	if ($strOrderBy)    $strQry .= ' ORDER BY '.$strOrderBy; 
	if ($strLimit)       $strQry .= ' LIMIT '.$strLimit; 
	if ($result = mysql_query($strQry))
	{
	    if (mysql_num_rows($result) > 0) 
	    {
	        return $result;
	    }
	}
	else
	{
	    die_mysql_error($strTableName.' query table data by '.$strQry.' failed');
	}
	return false;
}

function SqlGetSingleTableData($strTableName, $strWhere, $strOrderBy)
{
	$strQry = 'SELECT * FROM '.$strTableName;
	if ($strWhere)       $strQry .= ' WHERE '.$strWhere; 
	if ($strOrderBy)    $strQry .= ' ORDER BY '.$strOrderBy; 
	$strQry .= ' LIMIT 1'; 
	return SqlQuerySingleRecord($strQry, $strTableName.' query table data by '.$strWhere.' failed');
}

function SqlGetUniqueTableData($strTableName, $strWhere)
{
	if ($strWhere)
	{
		return SqlGetSingleTableData($strTableName, $strWhere, false);
	}
	return false;
}

function SqlGetTableDataById($strTableName, $strId)
{
	return SqlGetUniqueTableData($strTableName, _SqlBuildWhere('id', $strId));
}

function SqlDeleteTableData($strTableName, $strWhere, $strLimit)
{
    if ($strWhere)
    {
        $strQry = "DELETE FROM $strTableName WHERE $strWhere";
        if ($strLimit)  $strQry .= ' LIMIT '.$strLimit; 
        return SqlDieByQuery($strQry, $strTableName.' delete table data by '.$strQry.' failed');
    }
    return false;
}

function SqlDeleteTableDataById($strTableName, $strId)
{
    return SqlDeleteTableData($strTableName, _SqlBuildWhere('id', $strId), '1');
}

function SqlCountTableDataString($strTableName, $strWhere)
{
	$strQry = "SELECT count(*) as total FROM $strTableName";
	if ($strWhere)    $strQry .= ' WHERE '.$strWhere; 
	$result = mysql_query($strQry);
	$record = mysql_fetch_array($result);
	return $record['total'];
}

function SqlCountTableData($strTableName, $strWhere)
{
	return intval(SqlCountTableDataString($strTableName, $strWhere));
}

function SqlCountTableByDate($strTableName, $strDate)
{
    return SqlCountTableData($strTableName, _SqlBuildWhere('date', $strDate));
}

function SqlCountTableToday($strTableName)
{
    list($strDate, $strTime) = explodeDebugDateTime();
    return SqlCountTableByDate($strTableName, $strDate);
}

function SqlCreateDatabase($strDb)
{
	$str = "CREATE DATABASE `$strDb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	SqlDieByQuery($str, 'Create database failed');
	
/*
	$str = "CREATE TABLE `$strDb`.`member` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `email` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `password` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `ip` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `login` DATETIME NOT NULL, `register` DATETIME NOT NULL, `status` INT UNSIGNED NOT NULL, `activity` INT NOT NULL, INDEX (`ip`), UNIQUE (`email`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	$result = @mysql_query($str);
	if (!$result)	die('Create member table failed');

	$str = "CREATE TABLE `$strDb`.`blacklist` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `email` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `ip` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `created` DATETIME NOT NULL, `reason` INT UNSIGNED NOT NULL, INDEX (`ip`), UNIQUE (`email`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci"; 
	$result = @mysql_query($str);
	if (!$result)	die('Create blacklist table failed');

	$str = "CREATE TABLE `$strDb`.`profile` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `member_id` INT UNSIGNED NOT NULL, `name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `phone` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `address` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `web` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `signature` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	$result = @mysql_query($str);
	if (!$result)	die('Create profile table failed');

	$str = "CREATE TABLE `$strDb`.`blog` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `member_id` INT UNSIGNED NOT NULL, `uri` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE, UNIQUE (`uri`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci"; 
	$result = @mysql_query($str);
	if (!$result)	die('Create blog table failed');

 	$str = "CREATE TABLE `$strDb`.`blogcomment` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `member_id` INT UNSIGNED NOT NULL, `blog_id` INT UNSIGNED NOT NULL, `comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `ip` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `created` DATETIME NOT NULL, `modified` DATETIME NOT NULL, FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE, FOREIGN KEY (`blog_id`) REFERENCES `blog`(`id`) ON DELETE CASCADE, INDEX (`ip`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	$result = @mysql_query($str);
	if (!$result)	die('Create blogcomment table failed');

 	$str = "CREATE TABLE `$strDb`.`device` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `member_id` INT UNSIGNED NOT NULL, `hardware` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `software` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `service` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `number` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `pstn` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, `address` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE, INDEX (`address`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	$result = @mysql_query($str);
	if (!$result)	die('Create device table failed');
*/
	$db = mysql_select_db($strDb);		// Select database again
	if (!$db) 
	{
		die('Unable to select database');
	}
/*
	$strEmail = UrlGetEmail('support');
	SqlInsertMember($strEmail, $strEmail);

	$strEmail = UrlGetEmail('woody');
	SqlInsertMember($strEmail, $strEmail);*/
}

function SqlConnectDatabase()
{
    $strHost = DB_HOST;
    if (UrlGetDomain() == 'palmmicro.com')
    {
        $strHost = 'mysql';
    }
    
	$link = mysql_connect($strHost, DB_USER, DB_PASSWORD);	// Connect to mysql server
	if (!$link) 
	{
		die('Failed to connect to server: ' . mysql_error());
	}
	
	$db = mysql_select_db(DB_DATABASE);		// Select database
	if (!$db) 
	{
	    DebugString('No database yet, create it');
		SqlCreateDatabase(DB_DATABASE);
	}
	return true;
}

?>
