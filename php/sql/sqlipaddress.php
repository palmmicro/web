<?php
require_once('sqlkeyname.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_BLOCKED', '1');
define('IP_STATUS_CRAWL', '2');

class IpSql extends KeyNameSql
{
    function IpSql($strIp = false)
    {
        parent::KeyNameSql(TABLE_IP, 'ip', (filter_valid_ip($strIp) ? $strIp : false));
    }

    function Create()
    {
    	$str = ' `ip` VARCHAR( 16 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	  . ' `visit` INT UNSIGNED NOT NULL ,'
         	  . ' `login` INT UNSIGNED NOT NULL ,'
         	  . ' `status` INT UNSIGNED NOT NULL ,'
         	  . ' UNIQUE ( `ip` )';
        return $this->CreateKeyNameTable($str);
    }

    function _makeUpdateArray($strVisit = '0', $strLogin = '0', $strStatus = '0')
    {
    	return array('visit' => $strVisit,
    				  'login' => $strLogin,
    				  'status' => $strStatus);
    }
    
    function MakeInsertArray()
    {
    	return array_merge($this->MakeKeyArray(), $this->_makeUpdateArray());
    }
    
    function UpdateIp($strIp, $strVisit = '0', $strLogin = '0', $strStatus = '0')
    {
    	$ar = $this->_makeUpdateArray($strVisit, $strLogin, $strStatus);
    	if ($record = $this->GetRecord($strIp))
    	{	
    		if ($record['visit'] == $strVisit)		unset($ar['visit']);
    		if ($record['login'] == $strLogin)		unset($ar['login']);
    		if ($record['status'] == $strStatus)	unset($ar['status']);
    		if (count($ar) > 0)
    		{
    			return $this->UpdateById($ar, $record['id']);
    		}
    	}
    	return false;
    }

    function IncLogin($strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['login']);
    		$iVal ++;
    		return $this->UpdateIp($strIp, $record['visit'], strval($iVal), $record['status']);
    	}
    	return false;
    }

    function AddVisit($iCount, $strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['visit']);
    		$iVal += $iCount;
    		return $this->UpdateIp($strIp, strval($iVal), $record['login'], $record['status']);
    	}
    	return false;
    }

    function SetStatus($strStatus, $strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		if ($record['status'] != $strStatus)
    		{
    			return $this->UpdateIp($strIp, $record['visit'], $record['login'], $strStatus);
    		}
    		return true;
    	}
    	return false;
    }
    
    function GetStatus($strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		return $record['status'];
    	}
    	return false;
    }
}

?>
