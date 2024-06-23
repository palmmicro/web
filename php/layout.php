<?php
require_once('account.php');
require_once('menu.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('ui/echohtml.php');
require_once('class/Mobile_Detect.php');

define('DEFAULT_WIDTH', 640);
define('DEFAULT_DISPLAY_WIDTH', 900);
define('LEFT_MENU_WIDTH', 30 + 120 + 30 + 50);										// 最左边菜单宽度 width=30, 120, 30, 50
define('MIN_SCRREN_WIDTH', DEFAULT_DISPLAY_WIDTH + 10 + DEFAULT_ADSENSE_WIDTH);		// 隔10个像素再显示最右边的广告, 见下面width=10

function LayoutIsMobilePhone()
{
    $detect = new Mobile_Detect;
    if ($detect->isMobile() && !$detect->isTablet()) 
    {
        return true;
    }
    return false;
}

function ResizeJpg($strPathName, $iNewWidth = 300, $iNewHeight = 420)
{
	$strNewName = substr($strPathName, 0, strlen($strPathName) - 4).'x'.strval($iNewWidth).'y'.strval($iNewHeight).'__'.substr($strPathName, -4, 4);
	$strNewRootName = UrlModifyRootFileName($strNewName); 
	if (!file_exists($strNewRootName))
	{
		$imgOrg = imagecreatefromjpeg(UrlModifyRootFileName($strPathName));
		$iWidth = imagesx($imgOrg);
		$iHeight = imagesy($imgOrg);
		DebugString('Converting '.$strNewName);
		$imgNew = imagecreatetruecolor($iNewWidth, $iNewHeight);
		imagecopyresampled($imgNew, $imgOrg, 0, 0, 0, 0, $iNewWidth, $iNewHeight, $iWidth, $iHeight);
		imagejpeg($imgNew, $strNewRootName);
		imagedestroy($imgNew);
		imagedestroy($imgOrg);
	}
	return $strNewName;
}

//	https://ibkr.com/referral/rongrong586
function GetWeixinPay($iType = 0)
{
	if ($iType == 0)	$iType = rand(1, 2);
	switch ($iType)
	{
	case 1:
		$strImage = GetImgElement('/woody/image/wxpay.jpg', '微信打赏一块钱给Woody的二维码');
		$strText = GetRemarkElement('觉得这个网站有用？可以用微信打赏支持一下！');
		break;
        	
	case 2:
		$strPathName = ResizeJpg('/debug/wechat/9524e4c77bae0487.jpg');
		$strRemark = '华宝拖拉机开户微信群临时二维码';
		$strImage = GetImgElement($strPathName, $strRemark);
		$strText = GetFontElement($strRemark, 'navy');
		break;
	}
	
	return $strImage.'<br />'.$strText;
}

function LayoutScreenWidthOk()
{
	if (isset($_COOKIE['screenwidth']))
	{
		if ($strWidth = $_COOKIE['screenwidth'])
		{	// cookie in _layoutBanner worked 
			$iWidth = intval($strWidth);
			$iWidth -= 20;	// 假设右侧垂直滚动条最多20像素
			if ($iWidth >= MIN_SCRREN_WIDTH)	return $iWidth;
		}
	}
	return false;
}

function LayoutGetDisplayWidth()
{
	if ($iWidth = LayoutScreenWidthOk())
	{
		$iWidth -= 10 + DEFAULT_ADSENSE_WIDTH + LEFT_MENU_WIDTH;
		return ($iWidth < DEFAULT_WIDTH) ? DEFAULT_WIDTH : $iWidth;
	}
	return DEFAULT_WIDTH;
}

function LayoutUseWide()
{
	if ($_SESSION['mobile'])	return true;
	return (LayoutGetDisplayWidth() >= 1080) ? true : false;
}

function LayoutGetDisplayHeight()
{
	if (isset($_COOKIE['screenheight']))
	{
		if ($strHeight = $_COOKIE['screenheight'])
		{	// cookie in _layoutBanner worked 
			$iHeight = intval($strHeight);
			$iHeight -= 144;	// image_palmmicro.jpg 800*105像素
			return $iHeight;
		}
	}
	return 480;
}

function _layoutBanner($bChinese)
{
//    $ar = explode('/', UrlGetUri());
//	if ($ar[1] == 'woody')	$strImage = GetImgElement('/woody/image/image.jpg', 'Woody Home Page');
//	else
	$strImage = GetImgElement('/image/image_palmmicro.jpg', 'Palmmicro Name Logo');
	$strLink = GetLinkElement($strImage, '/index'.($bChinese ? 'cn' : '').'.html');
    
    echo <<<END

<div id="banner">
    <div class="logo">$strLink</div>
    <div class="blue"></div>
</div>

<script>
	var width = window.screen.width;
	var height = window.screen.height;
	document.cookie = "screenheight=" + height + "; path=/";
	document.cookie = "screenwidth=" + width + "; path=/";
</script>
END;
}

function _layoutAboveMenu($iWidth)
{
	if ($iWidth == false)	$iWidth = DEFAULT_DISPLAY_WIDTH;
	$strWidth = strval($iWidth);
	
    echo <<<END

<table width=$strWidth height=85% border=0 cellpadding=0 cellspacing=0>
<tbody>
<tr>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
	<div>
END;
/*    echo <<<END
        <div id="main">
            <div class="green">&nbsp;</div>
            <div class="nav">
END;*/
}

function _layoutBelowMenu($iWidth)
{
	if ($iWidth)		$strExtra = 'width='.strval($iWidth - MIN_SCRREN_WIDTH + DEFAULT_DISPLAY_WIDTH - LEFT_MENU_WIDTH);
	else 				$strExtra = '';
	
    echo <<<END
    
    </div>
</td>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td $strExtra valign=top>
END;
/*    echo <<<END
            </div>
            <div class="green2">&nbsp;</div>
            <div class="white">&nbsp;</div>
            <div class="edit">
END;*/
}

function GetSwitchLanguageLink($bChinese)
{
	if ($_SESSION['switchlanguage'] == false)	return '';

	// /woody/blog/entertainment/20140615cn.php ==> 20140615.php
    $str = UrlGetPage();
    $str .= UrlGetPhp(UrlIsEnglish());
    $str .= UrlPassQuery();
    return MenuGetLink($str, $bChinese ? GetImgElement('/image/us.gif', 'Switch to ').'English' : GetImgElement('/image/zh.jpg', '切换成').'中文');
}

function LayoutTopLeft($callback = false, $bSwitchLanguage = false, $bChinese = true, $bAdsense = true)
{
    if ($bAdsense)	EchoAnalyticsOptimize();
	$_SESSION['switchlanguage'] = $bSwitchLanguage;
    if ($_SESSION['mobile'])
    {
    	if ($bAdsense)	AdsensePalmmicroUser();
    }
    else
    {
        _layoutBanner($bChinese);
        
        $iWidth = LayoutScreenWidthOk();
        _layoutAboveMenu($iWidth);
        call_user_func($callback, $bChinese);
        _layoutBelowMenu($iWidth);
    }
}

function LayoutBegin()
{
    echo <<<END

<div>
END;
}

function LayoutEnd()
{
    echo <<<END

</div>
END;
}

function _echoWeixinPay($iType = 0)
{
	LayoutBegin();
	EchoParagraph(GetWeixinPay($iType));
	LayoutEnd();
}

// According to google policy, do NOT show Adsense in pages with no contents, such as input pages
function LayoutTail($bChinese = true, $bAdsense = false)
{
    if ($_SESSION['mobile'])
    {
		if ($bAdsense)	AdsenseContent();
   		else				_echoWeixinPay();
    }
    else
    {
    	if (LayoutScreenWidthOk())
    	{
    		echo <<<END

</td>
<td width=10 valign=top>&nbsp;</td>
<td valign=top>
END;
    		if ($bAdsense)	AdsenseLeft();
    		else				_echoWeixinPay();
    	}
    	else
    	{
    		if ($bAdsense)	AdsenseWoodyBlog();
    		else				_echoWeixinPay();
    	}
    	
        echo '</td></tr></tbody></table>';
//        echo '    </div>';
//        echo '</div>';
    }
    EchoCopyRight($_SESSION['mobile'], $bChinese);
}

?>
