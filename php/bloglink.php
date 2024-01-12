<?php

class BlogPageYMD extends StringYMD
{
    public function __construct($strPage)
    {
        parent::__construct(ConvertYMD($strPage));
    }
}

function GetBlogYmd($strDate, $bChinese = true)
{
	$ymd = new BlogPageYMD($strDate);
	return $ymd->GetDisplay($bChinese);
}

function GetBlogMonthDay($strDate, $bChinese = true)
{
	$ymd = new BlogPageYMD($strDate);
	return $ymd->GetMonthDayDisplay($bChinese);
}

function GetBlogLink($iDate, $bChinese = true, $bLink = true)
{
	$strMenu = 'entertainment';
	$strUs = false;
	
	switch ($iDate)
	{
	case 20161014:
		$strMenu = 'palmmicro';
		$strDisplay = '微信';
		$strUs = 'WeChat';
		break;
		
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
	
	if ($bLink)	return GetPhpLink('/woody/blog/'.$strMenu.'/'.strval($iDate), false, $strDisplay, $strUs, $bChinese);
	return $bChinese ? $strDisplay : ($strUs ? $strUs : $strDisplay);   
}

function GetBlogTitle($iDate, $bChinese = true, $bLink = true)
{
	$strDisplay = GetBlogLink($iDate, $bChinese, $bLink); 
	
	switch ($iDate)
	{
	case 20161014:
		$strTitle = $bChinese ? 'Palmmicro'.$strDisplay.'公众号sz162411' : 'Palmmicro '.$strDisplay.' Public Account sz162411';
		break;
		
	case 20150818:
		$strTitle = $bChinese ? $strDisplay.'净值估算的PHP程序' : 'PHP Application to Estimate '.$strDisplay.' Net Value';
		break;
		
	case 20141204:
		break;
		
	case 20141016:
		break;
		
	case 20110509:
		break;
		
	case 20100905:
		break;
		
	case 20080326:
		$strTitle = $bChinese ? $strDisplay.'域名的历史' : 'The History of '.$strDisplay.' Domain';
		break;
	}

	if ($bLink)
	{
		$strPage = UrlGetPage();
		$strDate = strval($iDate);
		$strDate = ($strPage == 'blog' || substr($strPage, 0, 5) == 'photo') ? GetBlogMonthDay($strDate, $bChinese) : GetBlogYmd($strDate, $bChinese); 
		return $strDate.' '.$strTitle;
	}
	return $strTitle;
}

?>
