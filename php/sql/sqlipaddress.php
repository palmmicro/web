<?php
require_once('sqltable.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_BLOCKED', '1');
define('IP_STATUS_CRAWL', '2');

// ****************************** IpSql class *******************************************************
class IpSql extends KeyNameSql
{
    function IpSql()
    {
        parent::KeyNameSql('ip', 'ip');
    }

    function Create()
    {
    	$str = ' `ip` VARCHAR( 16 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	. ' `visit` INT UNSIGNED NOT NULL ,'
         	. ' `login` INT UNSIGNED NOT NULL ,'
         	. ' `status` INT UNSIGNED NOT NULL ,'
         	. ' UNIQUE ( `ip` )';
    	return $this->CreateIdTable($str);
    }
    
    function WriteIp($strIp, $strVisit = '0', $strLogin = '0', $strStatus = '0')
    {
    	$ar = array('ip' => $strIp,
    				  'visit' => $strVisit,
    				  'login' => $strLogin,
    				  'status' => $strStatus);
    	
    	if ($record = $this->Get($strIp))
    	{	
    		unset($ar['ip']);
    		if ($record['visit'] == $strVisit)		unset($ar['visit']);
    		if ($record['login'] == $strLogin)		unset($ar['login']);
    		if ($record['status'] == $strStatus)	unset($ar['status']);
    		if (count($ar) > 0)
    		{
    			return $this->UpdateById($ar, $record['id']);
    		}
    	}
    	else
    	{
    		return $this->InsertData($ar);
    	}
    	return false;
    }
}

// ****************************** IP Address table *******************************************************
/*
function SqlCreateIpAddressTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`ipaddress` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `ip` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `visit` INT UNSIGNED NOT NULL ,'
         . ' `login` INT UNSIGNED NOT NULL ,'
         . ' `status` INT UNSIGNED NOT NULL ,'
         . ' UNIQUE ( `ip` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create ip table failed');
}

function SqlInsertIpAddress($strIp)
{
	$strQry = "INSERT INTO ipaddress(id, ip, visit, login, status) VALUES('0', '$strIp', '0', '0', '0')";
	return SqlDieByQuery($strQry, 'Insert ipaddress failed');
}

function SqlUpdateIpAddress($strIp, $strVisit, $strLogin, $strStatus)
{
	$strQry = "UPDATE ipaddress SET visit = '$strVisit', login = '$strLogin', status = '$strStatus' WHERE ip = '$strIp' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update ipaddress failed');
}
*/
function SqlGetIpAddress($strId)
{
/*    if ($record = SqlGetTableDataById(TABLE_IP_ADDRESS, $strId))
    {
		return $record['ip'];
	}
	return false;*/
	
   	$sql = new IpSql();
   	return $sql->GetKeyName($strId);
}

function SqlGetIpAddressRecord($strIp)
{
//	return SqlGetSingleTableData(TABLE_IP_ADDRESS, _SqlBuildWhere('ip', $strIp));
   	$sql = new IpSql();
   	return $sql->Get($strIp);
}

function SqlGetIpAddressId($strIp)
{
    if ($strIp)
    {
    	$sql = new IpSql();
    	return $sql->GetId($strIp);
/*        if ($record = SqlGetIpAddressRecord($strIp))
        {
            return $record['id'];
        }*/
    }
	return false;
}

function SqlGetIpStatus($strIp)
{
   	$sql = new IpSql();
	if ($record = $sql->Get($strIp))
//    if ($record = SqlGetIpAddressRecord($strIp))
    {
        return $record['status'];
    }
	return false;
}

function SqlSetIpStatus($strIp, $strStatus)
{
   	$sql = new IpSql();
	if ($record = $sql->Get($strIp))
//    if ($record = SqlGetIpAddressRecord($strIp))
    {
        if ($record['status'] != $strStatus)
        {
//            return SqlUpdateIpAddress($strIp, $record['visit'], $record['login'], $strStatus);
			return $sql->WriteIp($strIp, $record['visit'], $record['login'], $strStatus);
        }
        return true;
    }
	return false;
}

function SqlAddIpVisit($strIp, $iCount)
{
   	$sql = new IpSql();
	if ($record = $sql->Get($strIp))
//    if ($record = SqlGetIpAddressRecord($strIp))
    {
        $iVal = intval($record['visit']);
        $iVal += $iCount;
//        return SqlUpdateIpAddress($strIp, strval($iVal), $record['login'], $record['status']);
		return $sql->WriteIp($strIp, strval($iVal), $record['login'], $record['status']);
    }
	return false;
}

function SqlIncIpLogin($strIp)
{
   	$sql = new IpSql();
	if ($record = $sql->Get($strIp))
//    if ($record = SqlGetIpAddressRecord($strIp))
    {
        $iVal = intval($record['login']);
        $iVal ++;
//        return SqlUpdateIpAddress($strIp, $record['visit'], strval($iVal), $record['status']);
        return $sql->WriteIp($strIp, $record['visit'], strval($iVal), $record['status']);
    }
	return false;
}

function SqlMustGetIpId($strIp)
{
	$sql = new IpSql();
	if ($strId = $sql->GetId($strIp))
	{
		return $strId;
	}
	
	$sql->WriteIp($strIp);
	return $sql->GetId($strIp);
	
/*    SqlCreateIpAddressTable();
    $strIpId = SqlGetIpAddressId($strIp);
    if ($strIpId == false)
    {
        SqlInsertIpAddress($strIp);
        $strIpId = SqlGetIpAddressId($strIp);
    }
    return $strIpId;*/
}

?>
