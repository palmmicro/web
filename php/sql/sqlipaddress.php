<?php
require_once('sqlkeyname.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_BLOCKED', '1');
define('IP_STATUS_CRAWL', '2');

class IpSql extends KeyNameSql
{
    function IpSql($strIp = false)
    {
        parent::KeyNameSql(TABLE_IP, $strIp, 'ip');
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
    	if (filter_valid_ip($strIp) == false)	return false;
    	
    	$ar = array('ip' => $strIp,
    				  'visit' => $strVisit,
    				  'login' => $strLogin,
    				  'status' => $strStatus);
    	
    	if ($record = $this->GetRecord($strIp))
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
    		return $this->InsertArray($ar);
    	}
    	return false;
    }

    function InsertIp($strIp)
    {
    	if ($this->GetRecord($strIp) == false)
    	{
    		return $this->WriteIp($strIp);
    	}
    	return false;
    }
    
    function IncLogin($strIp)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['login']);
    		$iVal ++;
    		return $this->WriteIp($strIp, $record['visit'], strval($iVal), $record['status']);
    	}
    	return false;
    }

    function AddVisit($strIp, $iCount)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['visit']);
    		$iVal += $iCount;
    		return $this->WriteIp($strIp, strval($iVal), $record['login'], $record['status']);
    	}
    	return false;
    }

    function SetStatus($strIp, $strStatus)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		if ($record['status'] != $strStatus)
    		{
    			return $this->WriteIp($strIp, $record['visit'], $record['login'], $strStatus);
    		}
    		return true;
    	}
    	return false;
    }
    
    function GetStatus($strIp)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		return $record['status'];
    	}
    	return false;
    }
}

?>
