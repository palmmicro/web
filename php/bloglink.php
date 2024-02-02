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
	
	switch ($iDate)
	{
	case 20230614:
		$strDisplay = $bChinese ? '美元利息' : 'USD Interest';
		break;
		
	case 20201205:
		$strDisplay = $bChinese ? '雪球' : 'Snowball';
		break;
		
	case 20200424:
		$strDisplay = $bChinese ? '期货升水' : 'Futures Premium';
		break;
		
	case 20161014:
		$strMenu = 'palmmicro';
		$strDisplay = $bChinese ? '微信' : 'WeChat';
		break;
		
	case 20150818:
		$strDisplay = $bChinese ? '华宝油气' : 'SZ162411';
		break;
		
	case 20141204:
		$strDisplay = $bChinese ? '林近岚' : 'Mia Lin';
		break;
		
	case 20141016:
		$strDisplay = $bChinese ? '股票' : 'Stock';
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
	
	return $bLink ? GetPhpLink(PATH_BLOG.$strMenu.'/'.strval($iDate), false, $strDisplay, $bChinese) : $strDisplay;
}

function GetBlogTitle($iDate, $bChinese = true, $bLink = true)
{
	$strDisplay = GetBlogLink($iDate, $bChinese, $bLink); 
	switch ($iDate)
	{
	case 20230614:
		$strTitle = $bChinese ? '纳斯达克100期货升水和'.$strDisplay.'的关系' : 'Nasdaq 100 Futures Premium and '.$strDisplay;
		break;
		
	case 20201205:
		$strTitle = $bChinese ? $strDisplay.'私募的作业' : 'Homework for '.$strDisplay.' Private Equity';
		break;

	case 20200424:
		$strTitle = $bChinese ? '原油'.$strDisplay.'和油轮运价的对照计算' : 'Crude Oil '.$strDisplay.' and Tanker Rate';
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
	return GetPhpLink('/woody/photo', 'photo='.$strDate, $strDisplay, $bChinese);
}

function GetPhotoParagraph($strPathName, $strText = '', $bChinese = true, $strExtra = '')
{
	$str = $strExtra.' '.ImgAutoQuote($strPathName, $strText, $bChinese);
	$strDate = basename($strPathName, '.jpg');
	if (IsDigitDate($strDate))
	{
		$str = GetBlogMonthDay($strDate, $bChinese).' '.$str;
	}
	return GetHtmlElement($str);
}

function ImgPalmmicroWechat($bChinese = true)
{
	return GetImgQuote('/woody/image/wx.jpg', GetBlogTitle(20161014, $bChinese, false).($bChinese ? '小狐狸二维码' : ' small fox QR code'), $bChinese);
}

function ImgPortfolio20141016($bChinese = true)
{
	$strDate = '20141016';
	$strYmd = GetBlogYmd($strDate, $bChinese);
	return GetWoodyImgQuote($strDate.'.jpg', $strYmd.'A股持仓截屏', 'Screen shot of my Chinese A stock portfolio as of '.$strYmd.'.', $bChinese);
}

function ImgWoody20060701($bChinese = true)
{
	return GetImgQuote('/woody/myphoto/2006/baihuashan.jpg', GetBlogYmd('20060701', $bChinese).($bChinese ? '绿野百花山' : ' Baihua Mountain with Lvye.'), $bChinese);
}

function ImgWorriedWoody($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20141121/E55A5341.JPG', ($bChinese ? '我们两个都有点发愁' : 'Woody and Mia Lin are both worried!'), $bChinese);
}

function ImgSnowballCarnival($bChinese = true)
{
	return ImgAutoQuote('/woody/myphoto/2020/20201205.jpg', ($bChinese ? '2020年雪球嘉年华之夜' : '2020 Snowball carnival night'), $bChinese);
}

function ImgCMENQ20230614($bChinese = true)
{
	$strDate = '20230614';
	$strYmd = GetBlogYmd($strDate, $bChinese);
	return ImgAutoQuote(PATH_BLOG_PHOTO.$strDate.'.jpg', ($bChinese ? $strYmd.'纳斯达克100期货和现货价格比较' : 'Nasdaq 100 futures and market price comparison on '.$strYmd.'.'), $bChinese);
}

function ImgBelieveMe($bChinese = true)
{
	return ImgAutoQuote(PATH_BLOG_PHOTO.'believe.jpg', ($bChinese ? '至于你信不信，我反正信了。' : 'You believe it or not, I believe it anyway.'), $bChinese);
}

?>
