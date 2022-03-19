<?php
require_once('account.php');
require_once('menu.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('ui/echohtml.php');
require_once('class/Mobile_Detect.php');

define('DEFAULT_DISPLAY_WIDTH', 900);
define('MIN_SCRREN_WIDTH', DEFAULT_DISPLAY_WIDTH + 15 + DEFAULT_ADSENSE_WIDTH);		// 隔15个像素再显示最右边的广告, 见下面width=15

function LayoutIsMobilePhone()
{
    $detect = new Mobile_Detect;
    if ($detect->isMobile() && !$detect->isTablet()) 
    {
        return true;
    }
    return false;
}

/*
function _echoRandomPromotion()
{
	$iVal = rand(1, 3);
	switch ($iVal)
	{
	case 1:
		LayoutPromotion('iwantyou', 'IB盈透证券推荐开户链接：');
		break;
        	
	case 2:
		LayoutWeixinPay();
		break;

	case 3:
		LayoutPromotion('dongfang');
		break;
		
	case 4:
		LayoutPromotion('huabao');
		break;
		
	case 5:
		LayoutPromotion('yinhe', '著名网红营业部开户。请联系客服调整佣金 -- QQ:2531998595 微信:yhzqjn3');
		break;
	}
}

function LayoutPromotion($str, $strText = '')
{
	switch ($str)
	{
	case 'dongfang':
		$strLink = 'http://ognfhcacesaf4get.mikecrm.com/sEJIKQZ';
		break;
		
	case 'huabao':
		$strLink = 'https://m.touker.com/marketing/activity/KJFG.htm?channel=Vpalmmicro';
		break;
		
	case 'iwantyou':
		$strLink = 'https://ibkr.com/referral/rongrong586';
		break;
		
	case 'yinhe':
		$strLink = 'https://www.chinastock.com.cn/wskh/osoa/views/orderPage2.html?bn=2305&rn=23050226&bc=null&mc=230502262';
		break;
	}
	
	$strLink = GetExternalLink($strLink);
	$strImage = GetImgElement("/woody/image/$str.jpg", "$str promo"); 
    echo <<<END

    <p>$strImage
		<br />$strText
		<br />$strLink</p>
END;
}
*/

function LayoutWeixinPay()
{
	$strImage = GetImgElement('/woody/image/wxpay.jpg', 'QRcode to pay 1 RMB to Woody in Weixin');
	$strText = GetRemarkElement('觉得这个网站有用？可以用微信打赏支持一下！');
    echo <<<END

    <p>$strImage
    	<br />$strText</p>
END;
}

function LayoutScreenWidthOk()
{
	if (isset($_COOKIE['screen']))
	{
		if ($strWidth = $_COOKIE['screen'])
		{	// cookie in _layoutBanner worked 
			$iWidth = intval($strWidth) - 20;	// 假设右侧垂直滚动条是20像素
			if ($iWidth >= MIN_SCRREN_WIDTH)	return $iWidth;
		}
	}
	return false;
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
	document.cookie = "screen=" + width + "; path=/";
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
	if ($iWidth)		$strExtra = 'width='.strval($iWidth - MIN_SCRREN_WIDTH + DEFAULT_DISPLAY_WIDTH - 30 - 120 - 30 - 50);
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

function _echoWeixinPay()
{
	LayoutBegin();
	LayoutWeixinPay();
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
<td width=15 valign=top>&nbsp;</td>
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
