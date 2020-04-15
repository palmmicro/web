<?php
require_once('/php/account.php');

    AcctSessionStart();
	if (AcctIsAdmin())
	{
	    if ($strSrc = UrlGetQueryValue('delete'))
	    {
	    	AcctDeleteBlogVisitorByIp(new IpSql($strSrc));
	    }
	}

	SwitchToSess();
?>
