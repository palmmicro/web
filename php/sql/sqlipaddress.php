<?php
require_once('sqltable.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_CRAWLER', '1');

class IpSql extends TableSql
{
	var $strIp;
	
    function IpSql($strIp = false)
    {
        parent::TableSql(TABLE_IP);
        
        if ($this->strIp = (filter_valid_ip($strIp) ? $strIp : false))
        {
       		$this->InsertIp($strIp);
        }
    }

    function Create()
    {
    	$str = ' `id` INT UNSIGNED NOT NULL PRIMARY KEY,'
         	  . ' `visit` INT UNSIGNED NOT NULL ,'
         	  . ' `login` SMALLINT UNSIGNED NOT NULL ,'
         	  . ' `status` TINYINT UNSIGNED NOT NULL ,'
         	  . ' INDEX ( `status` )';
    	return $this->CreateTable($str);
    }

    function GetIp($strId = false)
    {
    	if ($strId)
    	{
    		return long2ip($strId);
    	}
    	return $this->strIp;
    }
    
    function GetId($strVal = false, $callback = 'GetRecord')
    {
    	$strIp = $strVal ? $strVal : $this->strIp;
   		return sprintf("%u", ip2long($strIp));
    }

    function GetRecord($strIp = false)
    {
   		return $this->GetRecordById($this->GetId($strIp));
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
       		if ($strId = $this->GetId($strIp))
       		{
       			return $this->InsertArray(array_merge(array('id' => $strId), $this->_makeUpdateArray()));
       		}
       	}
		return false;
    }
    
    function UpdateIp($strVisit, $strLogin, $strStatus, $strIp = false)
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
    		return $this->UpdateIp($record['visit'], strval($iVal), $record['status'], $strIp);
    	}
    	return false;
    }

    function AddVisit($iCount, $strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		$iVal = intval($record['visit']);
    		$iVal += $iCount;
    		return $this->UpdateIp(strval($iVal), $record['login'], $record['status'], $strIp);
    	}
    	return false;
    }

    function SetStatus($strStatus, $strIp = false)
    {
    	if ($record = $this->GetRecord($strIp))
    	{
    		if ($record['status'] != $strStatus)
    		{
    			return $this->UpdateIp($record['visit'], $record['login'], $strStatus, $strIp);
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
