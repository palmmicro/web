<?php
define('PATH_BLOG', '/woody/blog/');

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
	case 20201205:
		$strDisplay = '雪球';
		$strUs = 'Snowball';
		break;
		
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
		$strUs = 'Mia Lin';
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
	
	if ($bLink)	return GetPhpLink(PATH_BLOG.$strMenu.'/'.strval($iDate), false, $strDisplay, $strUs, $bChinese);
	return $bChinese ? $strDisplay : ($strUs ? $strUs : $strDisplay);   
}

function GetBlogTitle($iDate, $bChinese = true, $bLink = true)
{
	$strDisplay = GetBlogLink($iDate, $bChinese, $bLink); 
	
	switch ($iDate)
	{
	case 20201205:
		$strTitle = $bChinese ? $strDisplay.'私募的作业' : 'Homework for '.$strDisplay.' Private Equity';
		break;
		
	case 20161014:
		$strTitle = $bChinese ? 'Palmmicro'.$strDisplay.'公众号sz162411' : 'Palmmicro '.$strDisplay.' Public Account sz162411';
		break;
		
	case 20150818:
		$strTitle = $bChinese ? $strDisplay.'净值估算的PHP程序' : 'PHP Application to Estimate '.$strDisplay.' Net Value';
		break;
		
	case 20141204:
		$strTitle = $bChinese ? $strDisplay.'的由来' : 'The Origin of '.$strDisplay;
		break;
		
	case 20141016:
		$strTitle = $bChinese ? '从上证大型国有'.$strDisplay.'获利' : 'Trading Rules for Giant Chinese State-owned '.$strDisplay;
		break;
		
	case 20110509:
		$strTitle = $strDisplay.($bChinese ? '投放的广告' : ' AdSense');
		break;
		
	case 20100905:
		$strTitle = $bChinese ? '我的第一个'.$strDisplay.'程序' : 'My First '.$strDisplay.' Application';
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

function IsDigitDate($strDate)
{
	if (strlen($strDate) != 8)	return false;
	return is_numeric($strDate);
}

function GetPhotoDirLink($strDate, $bChinese = true, $bMonthDay = true)
{
	$strDisplay = $bMonthDay ? GetBlogMonthDay($strDate, $bChinese) : GetBlogYmd($strDate, $bChinese);
	return GetPhpLink('/woody/photo', 'photo='.$strDate, $strDisplay, false, $bChinese);
}

function GetPhotoParagraph($strPathName, $strTextCn, $strTextUs = '', $bChinese = true, $strExtra = '')
{
	$str = $strExtra.' '.ImgAutoQuote($strPathName, $strTextCn, $strTextUs, $bChinese);
	$strDate = basename($strPathName, '.jpg');
	if (IsDigitDate($strDate))
	{
		$str = GetBlogMonthDay($strDate, $bChinese).' '.$str;
	}
	return GetHtmlElement($str);
}

function ImgPalmmicroWechat($bChinese = true)
{
	$strTitle = GetBlogTitle(20161014, $bChinese, false);
	return GetImgQuote('/woody/image/wx.jpg', $strTitle.'小狐狸二维码', $strTitle.' small fox QR code', $bChinese);
}

function ImgPortfolio20141016($bChinese = true)
{
	$strDate = '20141016';
	$strYmd = GetBlogYmd($strDate, $bChinese);
	return GetWoodyImgQuote($strDate.'.jpg', $strYmd.'A股持仓截屏', 'Screen shot of my Chinese A stock portfolio as of '.$strYmd.'.', $bChinese);
}

function ImgWoody20060701($bChinese = true)
{
	$strYmd = GetBlogYmd('20060701', $bChinese);
	return GetImgQuote('/woody/myphoto/2006/baihuashan.jpg', $strYmd.'绿野百花山', $strYmd.' Baihua Mountain with Lvye.', $bChinese);
}

function ImgWorriedWoody($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20141121/E55A5341.JPG', '我们两个都有点发愁', 'Woody and Mia Lin are both worried!', $bChinese);
}

function ImgSnowballCarnival($bChinese = true)
{
	return ImgAutoQuote('/woody/myphoto/2020/20201205.jpg', '2020年雪球嘉年华之夜', '2020 Snowball carnival night', $bChinese);
}

?>
