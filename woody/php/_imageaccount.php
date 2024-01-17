<?php

class ImageAccount extends TitleAccount
{
    // photo2006 -> 2006
    function GetPageYear()
    {
    	$strPage = $this->GetPage();
    	$iLen = strlen($strPage) - strlen('photo');
    	return substr($strPage, -$iLen, $iLen);
    }
}

?>
