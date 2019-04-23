<?php
require_once('account.php');
require_once('ui/editinputform.php');

function UrlReplaceQuery($str, $strKey, $strVal)
{
	$strKeyVal = $strKey.'='.$strVal;
	if ($iPos = strpos($str, '?'))
	{
		$iPos ++;	
	    $strQuery = substr($str, $iPos, strlen($str) - $iPos);
//	    DebugString($strQuery);
	    $str = substr($str, 0, $iPos);
	    
	    $bMatch = false;
    	$ar = explode('&', $strQuery);
    	foreach ($ar as $strItem)
    	{
    		$iPos = strpos($strItem, '=');
    		if ($strKey == substr($strItem, 0, $iPos))
    		{
    			$str .= $strKeyVal;
    			$bMatch = true;
    		}
    		else
    		{
    			$str .= $strItem;
    		}
    		$str .= '&';
    	}
    	if ($bMatch)	$str = rtrim($str, '&');
    	else			$str .= $strKeyVal;
	}
	else
	{
		$str .= '?'.$strKeyVal;
	}
	return $str;
}

    AcctSessionStart();
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strInput = UrlCleanString($_POST[EDIT_INPUT_NAME]);
		if (!empty($strInput))
		{
			$strLink = UrlReplaceQuery(SwitchGetSess(), EDIT_INPUT_NAME, $strInput);
//			DebugString('_submitinput.php '.$strLink);
			SwitchToLink($strLink);
		}
	}
	SwitchToSess();
	
?>
