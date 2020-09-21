<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
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

function EchoInsideHead()
{
	$_SESSION['mobile'] = LayoutIsMobilePhone();
	$strViewPort = $_SESSION['mobile'] ? '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' : '';
//	$strViewPort = $_SESSION['mobile'] ? '<meta name="viewport" content="width=640, initial-scale=1.0"/>' : '';
	$strCanonical = str_replace('www.', '', UrlGetServer()).UrlGetUri();
	$strFavicon = '/image/favicon.ico';
	
    echo <<<END
    	<link rel="canonical" href="$strCanonical" />
    	<link rel="shortcut icon" href="$strFavicon" type="image/x-icon">
    	$strViewPort
END;
}

function LayoutPromotion($str, $strLink = false)
{
	$strLinkDisplay = $strLink ? '<br />'.GetHttpLink($strLink) : '';
    echo <<<END
        <p>
        	<img src=/woody/image/$str.jpg alt="$str promo" />
        	$strLinkDisplay
        </p>
END;
}

function LayoutWeixinPromotion()
{
	$strWeixin = GetWeixinDevLink();
    echo <<<END
        <p>请扫二维码关注Palmmicro{$strWeixin}sz162411. 
        <br /><img src=/woody/image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
        </p>
END;
}

function LayoutWeixinPay()
{
    echo <<<END
        <p><img src=/woody/image/wxpay.jpg alt="QRcode to pay 1 RMB to Woody in Weixin" />
        <br /><font color=green>觉得这个网站有用? 可以用微信打赏支持一下.</font>
        </p>
END;
}

function LayoutAliPay()
{
    echo <<<END
        <p><img src=/woody/image/alipay.jpg alt="QRcode to pay Woody in Taobao" />
        <br /><font color=green>觉得这个网站有用? 可以用支付宝打赏支持一下.</font>
        </p>
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

        <script type="text/javascript">
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
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
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
</TABLE>
</TD>
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
    $str = UrlGetTitle();
    $str .= UrlGetPhp(UrlIsEnglish());
    $str .= UrlPassQuery();
    if ($bChinese)
    {
    	return "<A class=A2 HREF=\"$str\"><img src=/image/us.gif alt=\"Switch to English\" />English</A>";
    }
    else
    {
    	return "<A class=A2 HREF=\"$str\"><img src=/image/zh.jpg alt=\"Switch to Chinese\" />中文</A>";
    }
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

// According to google policy, do NOT show Adsense in pages with no contents, such as input pages
function LayoutTail($bChinese = true, $bAdsense = false)
{
    if ($_SESSION['mobile'])
    {
		if ($bAdsense)	AdsenseContent();
   		else
   		{
   			echo '<div>';
   			LayoutWeixinPay();
   			echo '</div>';
   		}
    }
    else
    {
    	if (LayoutScreenWidthOk())
    	{
    		echo '</td><td width=15 valign=top>&nbsp;</td><td valign=top>';
    		if ($bAdsense)	AdsenseLeft();
    		else
    		{
    			echo '<div>';
    			LayoutWeixinPay();
    			LayoutWeixinPromotion();
    			echo '</div>';
    		}
    	}
    	else
    	{
    		if ($bAdsense)	AdsenseWoodyBlog();
    		else
    		{
    			echo '<div>';
    			LayoutAliPay();
    			echo '</div>';
    		}
    	}
    	
        echo '</td></table>';
//        echo '    </div>';
//        echo '</div>';
    }
    EchoCopyRight($_SESSION['mobile'], $bChinese);
}

function LayoutTailLogin($bChinese = true)
{
    VisitorLogin($bChinese);
    LayoutTail($bChinese, true);
}

?>
