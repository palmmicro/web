<?php

function GetBlogLink($strDate, $bChinese = true)
{
	$strMenu = 'entertainment';
	switch ($strDate)
	{
	case '20150818':
		$strDisplay = '华宝油气';
		$strUs = 'SZ162411';
		break;
		
	case '20141204':
		$strDisplay = '林近岚';
		$strUs = 'Sapphire Lin';
		break;
	}
	
	return GetPhpLink('/woody/blog/'.$strMenu.'/'.$strDate, false, $strDisplay, $strUs, $bChinese);
}

?>
