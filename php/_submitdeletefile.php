<?php
require_once('account.php');

    AcctNoAuth();
	if (AcctIsAdmin())
	{
	    if ($strPathName = UrlGetQueryValue('delete'))
	    {
	        unlinkEmptyFile($strPathName);
	        EmailDebug('Deleted file: '.DebugFileLink($strPathName), 'Deleted debug file'); 
	    }
	}
	
	SwitchToSess();

?>
