<?php

// ****************************** IP Address table *******************************************************

define ('IP_STATUS_NORMAL', '0');
define ('IP_STATUS_BLOCKED', '1');

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

function SqlGetIpAddress($strId)
{
    if ($record = SqlGetTableDataById(TABLE_IP_ADDRESS, $strId))
    {
		return $record['ip'];
	}
	return false;
}

function SqlGetIpAddressRecord($strIp)
{
	return SqlGetSingleTableData(TABLE_IP_ADDRESS, _SqlBuildWhere('ip', $strIp));
}

function SqlGetIpAddressId($strIp)
{
    if ($strIp)
    {
        if ($record = SqlGetIpAddressRecord($strIp))
        {
            return $record['id'];
        }
    }
	return false;
}

function SqlSetIpStatus($strIp, $strStatus)
{
    if ($record = SqlGetIpAddressRecord($strIp))
    {
        if ($record['status'] != $strStatus)
        {
            return SqlUpdateIpAddress($strIp, $record['visit'], $record['login'], $strStatus);
        }
        return true;
    }
	return false;
}

function SqlAddIpVisit($strIp, $iCount)
{
    if ($record = SqlGetIpAddressRecord($strIp))
    {
        $iVal = intval($record['visit']);
        $iVal += $iCount;
        return SqlUpdateIpAddress($strIp, strval($iVal), $record['login'], $record['status']);
    }
	return false;
}

function SqlIncIpLogin($strIp)
{
    if ($record = SqlGetIpAddressRecord($strIp))
    {
        $iVal = intval($record['login']);
        $iVal ++;
        return SqlUpdateIpAddress($strIp, $record['visit'], strval($iVal), $record['status']);
    }
	return false;
}

function SqlMustGetIpId($strIp)
{
//    SqlCreateIpAddressTable();
    $strIpId = SqlGetIpAddressId($strIp);
    if ($strIpId == false)
    {
        SqlInsertIpAddress($strIp);
        $strIpId = SqlGetIpAddressId($strIp);
    }
    return $strIpId;
}

?>
