<?php
require_once('sqltable.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_CRAWLER', '1');

function GetIp($strId)
{
	return long2ip($strId);
}
    
function GetIpId($strIp)
{
	return sprintf("%u", ip2long($strIp));
}

class IpSql extends TableSql
{
    function IpSql()
    {
        parent::TableSql(TABLE_IP);
    }

    public function Create()
    {
    	$str = ' `id` INT UNSIGNED NOT NULL PRIMARY KEY,'
         	  . ' `visit` INT UNSIGNED NOT NULL ,'
         	  . ' `login` SMALLINT UNSIGNED NOT NULL ,'
         	  . ' `status` TINYINT UNSIGNED NOT NULL ,'
         	  . ' INDEX ( `status` )';
    	return $this->CreateTable($str);
    }

    public function GetRecord($strIp)
    {
   		return $this->GetRecordById(GetIpId($strIp));
    }

    function _makeUpdateArray($strVisit = '0', $strLogin = '0', $strStatus = '0')
    {
    	return array('visit' => $strVisit,
    				  'login' => $strLogin,
    				  'status' => $strStatus);
    }

    function InsertIp($strIp)
    {
       	if ($this->GetRecord($strIp) == false)
       	{
       		if ($strId = GetIpId($strIp))
       		{
       			return $this->InsertArray(array_merge(array('id' => $strId), $this->_makeUpdateArray()));
       		}
       	}
		return false;
    }
    
    function UpdateIp($strIp, $strVisit, $strLogin, $strStatus)
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

    function IncLogin($strIp)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['login']);
    		$iVal ++;
    		return $this->UpdateIp($strIp, $record['visit'], strval($iVal), $record['status']);
    	}
    	return false;
    }

    function AddVisit($strIp, $iCount)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['visit']);
    		$iVal += $iCount;
    		return $this->UpdateIp($strIp, strval($iVal), $record['login'], $record['status']);
    	}
    	return false;
    }

    function SetStatus($strIp, $strStatus)
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
