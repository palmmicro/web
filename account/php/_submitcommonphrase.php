<?php
require_once('/php/account.php');
require_once('/php/sql/sqlkeystring.php');

   	$acct = new Account();
	if ($strMemberId = $acct->GetLoginId())
	{
	    if ($strId = UrlGetQueryValue('delete'))
	    {
	    	$sql = new CommonPhraseSql();
	    	if ($strMemberId == $sql->GetKeyId($strId))
	    	{
	    		$sql->DeleteById($strId);
	    	}
	    }
	}

	$acct->Back();
?>
