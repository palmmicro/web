<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'woody');
define('DB_DATABASE', 'camman');

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
    
    $strAnd = ' AND ';
    $strWhere = '';
    $arQuery = explode('&', $strQuery);
    foreach ($arQuery as $str)
    {
        $ar = explode('=', $str);
        if ($str = _SqlBuildWhere($ar[0], $ar[1]))
        {
            $strWhere .= $str.$strAnd;
        }
    }
    
    if ($strWhere != '')
    {
        return rtrim($strWhere, $strAnd); 
    }
    return false;
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
	$result = @mysql_query($str);
	if (!$result)	die($strTableName.' Drop table failed');
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

function SqlGetTableDataById($strTableName, $strId)
{
	$strQry = "SELECT * FROM $strTableName WHERE id = '$strId' LIMIT 1";
	return SqlQuerySingleRecord($strQry, $strTableName.' query table data by id failed');
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

function SqlCountTableData($strTableName, $strWhere)
{
	$strQry = "SELECT count(*) as total FROM $strTableName";
	if ($strWhere)    $strQry .= ' WHERE '.$strWhere; 
	$result = mysql_query($strQry);
	$record = mysql_fetch_array($result);
	return intval($record['total']);
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
