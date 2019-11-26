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
	        trigger_error('Deleted debug file: '.GetFileLink($strPathName)); 
	    }
	    else
	    {
	    	if (_deleteTableDataById(TABLE_NETVALUE_HISTORY))			{}
	    }
	}
	
	SwitchToSess();

?>
