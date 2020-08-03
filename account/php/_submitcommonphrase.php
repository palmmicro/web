<?php
require_once('/php/account.php');
require_once('/php/sql/sqlcommonphrase.php');

   	$acct = new Account();
	if ($strMemberId = $acct->GetLoginId())
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

	$acct->Back();
?>
