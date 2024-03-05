<?php

function SwitchToLink($strLink)
{
	header('location: '.$strLink);
	exit();
}

function SwitchTo($strPage)
{
	SwitchToLink($strPage.UrlGetType());
}

function SwitchSetSess()
{
	$_SESSION['userurl'] = UrlGetCur();
}

function SwitchGetSess()
{
    if (isset($_SESSION['userurl'])) 
    { 
    	return $_SESSION['userurl'];
    }
    return false;
}

function _removeFromSess($strQuery)
{
	if ($str = SwitchGetSess())
	{
		if (stripos($str, $strQuery))
		{
			$_SESSION['userurl'] = str_ireplace($strQuery, '', $str);
			DebugString('new session url: '.$_SESSION['userurl']);
			return true;
		}
	}
	return false;
}

function SwitchRemoveFromSess($strQuery)
{
	if (_removeFromSess('&'.$strQuery))	return;
	if (_removeFromSess('?'.$strQuery))	return;
	_removeFromSess($strQuery);
}

function SwitchToSess()
{
    if (isset($_SESSION['userurl'])) 
    { 
//        $url = $_SESSION['userurl']; 
//        echo "<meta http-equiv=\"refresh\" content=\"0.5;url=$url\">";  //0.5s后跳转 
		$strLink = $_SESSION['userurl'];
		unset($_SESSION['userurl']);
		SwitchToLink($strLink);
    }
    else
    {
    	DebugString(__FUNCTION__.' lost ...');
    }
/*	if (isset($_SERVER["HTTP_REFERER"]))
	{
		SwitchToLink($_SERVER["HTTP_REFERER"]);
	}
*/
}


?>
