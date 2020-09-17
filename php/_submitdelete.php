<?php
require_once('account.php');
require_once('sql/sqlstock.php');

function _deleteTableDataById($strTableName)
{
	if ($strId = UrlGetQueryValue($strTableName))
	{
		$sql = new TableSql($strTableName);
		return $sql->DeleteById($strId);
    }
    return false;
}

class _AdminDeleteAccount extends Account
{
	function DeleteVisitorByIp($strIp)
	{
   		$sql = $this->GetIpSql();
		if ($strId = GetIpId($strIp))
		{
			$visitor_sql = $this->GetVisitorSql();
			$iCount = $visitor_sql->CountBySrc($strId);
			$visitor_sql->DeleteBySrc($strId);        

			$sql->AddVisit($strIp, $iCount);
		}
		$sql->SetStatus($strIp, IP_STATUS_NORMAL);
	}

    function AdminProcess()
    {
    	if ($strPathName = UrlGetQueryValue('file'))
    	{
    		unlinkEmptyFile($strPathName);
    		trigger_error('Deleted debug file: '.GetFileLink($strPathName)); 
    	}
    	else if ($strIp = UrlGetQueryValue(TABLE_IP))
    	{
    		$this->DeleteVisitorByIp($strIp);
    	}
    	else
    	{
    		if (_deleteTableDataById(TABLE_NETVALUE_HISTORY))			
    		{
    		}
    		else if (_deleteTableDataById(TABLE_STOCK_CALIBRATION))
    		{
//    			DebugString('Deleted data from '.TABLE_STOCK_CALIBRATION);
			}
		}
    }
}

   	$acct = new _AdminDeleteAccount();
	$acct->AdminRun();
?>
