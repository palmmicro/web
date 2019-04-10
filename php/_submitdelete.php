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

    AcctNoAuth();
	if (AcctIsAdmin())
	{
	    if ($strPathName = UrlGetQueryValue('file'))
	    {
	        unlinkEmptyFile($strPathName);
	        EmailReport('Deleted file: '.GetFileLink($strPathName), 'Deleted debug file'); 
	    }
	    else
	    {
	    	if (_deleteTableDataById(TABLE_NETVALUE_HISTORY))			{}
	    	else if (_deleteTableDataById(TABLE_ETF_CALIBRATION))	{}
	    }
	}
	
	SwitchToSess();

?>
