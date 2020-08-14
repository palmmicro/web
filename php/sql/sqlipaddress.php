<?php
require_once('sqltable.php');

define('IP_STATUS_NORMAL', '0');
define('IP_STATUS_CRAWL', '1');

class IpSql extends TableSql
{
	var $strIp;
	var $strId = false;
	
    function IpSql($strIp = false)
    {
        parent::TableSql(TABLE_IP);
        
        if ($this->strIp = (filter_valid_ip($strIp) ? $strIp : false))
        {
			$this->strId = $this->GetId($strIp);
        	if ($this->GetRecord() == false)
        	{
   				$this->InsertArray(array_merge(array('id' => $this->strId), $this->_makeUpdateArray()));
        	}
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
    	if ($strVal)
    	{
    		return sprintf("%u", ip2long($strVal));
    	}
    	return $this->strId;
    }

    function GetRecord($strIp = false)
    {
    	if ($strIp)
    	{
    		return $this->GetRecordById($this->GetId($strIp));
    	}
    	else if ($this->strIp)
    	{
    		return $this->GetRecordById($this->strId);
    	}
    	return false;
    }

    function _makeUpdateArray($strVisit = '0', $strLogin = '0', $strStatus = '0')
    {
    	return array('visit' => $strVisit,
    				  'login' => $strLogin,
    				  'status' => $strStatus);
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
