<?php
require_once('email.php');
require_once('account.php');

    AcctNoAuth();

	if ($strPathName = UrlGetQueryValue('delete'))
	{
	    if (AcctIsAdmin())
	    {
	        unlinkEmptyFile($strPathName);
	        EmailDebug('Deleted file: '.DebugFileLink(UrlGetServer().$strPathName), 'Deleted debug file'); 
	    }
	}
	
	SwitchToSess();

?>
