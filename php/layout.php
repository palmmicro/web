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
	
	$strLinkDisplay = GetHttpLink($strLink);
    echo <<<END

    <p><img src=/woody/image/$str.jpg alt="$str promo" />
		<br />$strText
		<br />$strLinkDisplay</p>
END;
}

function LayoutWeixinPay()
{
    echo <<<END

    <p><img src=/woody/image/wxpay.jpg alt="QRcode to pay 1 RMB to Woody in Weixin" />
    	<br /><font color=green>觉得这个网站有用? 可以用微信打赏支持一下.</font></p>
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
    $ar = explode('/', UrlGetUri());
    $strHome = $bChinese ? 'indexcn.html' : 'index.html';
	if ($ar[1] == 'woody')
	{
	    $strImage = 'img src=/woody/image/image.jpg alt="Woody Home Page" /';
	}
	else
	{
	    $strImage = 'img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /';
	}
    
    echo <<<END

<div id="banner">
    <div class="logo"><a href="/$strHome"><$strImage></a></div>
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

//<TR><TD><A class=A2 HREF="logincn.php"><img src=../image/zh.jpg alt="Switch to Chinese" />Chinese</A></TD></TR>
//<TR><TD><A class=A2 HREF="login.php"><img src=../image/us.gif alt="Switch to English" />English</A></TD></TR>
function GetSwitchLanguageLink($bChinese)
{
	if ($_SESSION['switchlanguage'] == false)	return '';

	// /woody/blog/entertainment/20140615cn.php ==> 20140615.php
    $str = UrlGetPage();
    $str .= UrlGetPhp(UrlIsEnglish());
    $str .= UrlPassQuery();
    return MenuGetLink($str, $bChinese ? "<img src=/image/us.gif alt=\"Switch to English\" />English" : "<img src=/image/zh.jpg alt=\"Switch to Chinese\" />中文");
}

function LayoutTopLeft($callback = false, $bSwitchLanguage = false, $bChinese = true, $bAdsense = true)
{
    EchoAnalyticsOptimize();
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
