<?php
require_once('../php/account.php');
require_once('../php/sql/sqlkeystring.php');

class _SubmitPhraseAccount extends Account
{
    public function Process($strLoginId)
    {
		if (!$strLoginId)					return;

	    if ($strId = UrlGetQueryValue('delete'))
	    {
	    	$sql = new CommonPhraseSql();
	    	if ($strLoginId == $sql->GetKeyId($strId))
	    	{
	    		$sql->DeleteById($strId);
	    	}
	    }
	}
}

?>
