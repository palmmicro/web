<?php

function GetBlogLink($iDate, $bChinese = true)
{
	$strMenu = 'entertainment';
	$strUs = false;
	
	switch ($iDate)
	{
	case 20150818:
		$strDisplay = '华宝油气';
		$strUs = 'SZ162411';
		break;
		
	case 20141204:
		$strDisplay = '林近岚';
		$strUs = 'Sapphire Lin';
		break;
		
	case 20141016:
		$strDisplay = '股票';
		$strUs = 'Stock';
		break;
		
	case 20110509:
		$strDisplay = 'Google';
		break;
		
	case 20100905:
		$strDisplay = 'PHP';
		break;
		
	case 20080326:
		$strMenu = 'palmmicro';
		$strDisplay = 'Palmmicro';
		break;
	}
	
	return GetPhpLink('/woody/blog/'.$strMenu.'/'.strval($iDate), false, $strDisplay, $strUs, $bChinese);
}

?>
