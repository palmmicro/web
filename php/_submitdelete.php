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

function _DeleteFileOrTableData()
{
    if ($strPathName = UrlGetQueryValue('file'))
    {
        unlinkEmptyFile($strPathName);
        trigger_error('Deleted debug file: '.GetFileLink($strPathName)); 
    }
    else
    {
    	if (_deleteTableDataById(TABLE_NETVALUE_HISTORY))			
    	{
    	}
    	else if (_deleteTableDataById(TABLE_STOCK_CALIBRATION))
    	{
//    		DebugString('Deleted data from '.TABLE_STOCK_CALIBRATION);
    	}
	}
}
	
   	$acct = new Account();
	$acct->AdminCommand('_DeleteFileOrTableData');
?>
