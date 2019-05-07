<?php
require_once('/php/account.php');
require_once('/php/sql/sqlcommonphrase.php');

    AcctSessionStart();
	if ($strMemberId = AcctIsLogin()) 
	{
	    if ($strId = UrlGetQueryValue('delete'))
	    {
	    	$sql = new CommonPhraseSql($strMemberId);
	    	if ($strMemberId == $sql->GetKeyId($strId))
	    	{
	    		$sql->DeleteById($strId);
	    	}
	    }
	}

	SwitchToSess();
?>
