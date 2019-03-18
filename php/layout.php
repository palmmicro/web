<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('class/Mobile_Detect.php');

define('DEFAULT_DISPLAY_WIDTH', 900);
define('MIN_SCRREN_WIDTH', DEFAULT_DISPLAY_WIDTH + 15 + DEFAULT_ADSENSE_WIDTH);		// 隔15个像素再显示最右边的广告, 见下面width=15

function LayoutQQgroupPromotion()
{
    echo <<<END
        <p>请扫二维码或者点击链接加入Woody创建的QQ群204836363
        <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=2eb90427cf5fc1c14f4ebd8f72351d4a09e259cf48f137e312cd54163bd5c165"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="Alcoholic Anonymus" title="Alcoholic Anonymus"></a>
        <br /><img src=/woody/image/qq.jpg alt="QQ group 204836363 scan QR code" />
        </p>
END;
}

function LayoutWeixinPromotion()
{
    echo <<<END
        <p>请扫二维码关注Palmmicro<a href="/woody/blog/palmmicro/20161014cn.php">微信公众订阅号</a>sz162411. 
        <br /><img src=/woody/image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
        </p>
END;
}

function LayoutMyPromotion()
{
    echo <<<END
        <p>觉得这个网站有用? 可以打赏支持一下. 
        <br /><img src=/woody/image/taobao.jpg alt="QRcode to pay Woody in Taobao" />
        <br /><img src=/woody/image/wxpay.jpg alt="QRcode to pay 1 RMB to Woody in Weixin" />
        </p>
END;
}

function LayoutIsMobilePhone()
{
    $detect = new Mobile_Detect;
    if ($detect->isMobile() && !$detect->isTablet()) 
    {
        return true;
    }
    return false;
}

function LayoutScreenWidthOk()
{
	if ($strWidth = $_COOKIE['screen'])
	{	// cookie in _layoutBanner worked 
		$iWidth = intval($strWidth) - 20;	// 假设右侧垂直滚动条是20像素
		if ($iWidth >= MIN_SCRREN_WIDTH)	return $iWidth;
	}
	return false;
}

function _layoutBanner($bChinese)
{
    $ar = explode('/', UrlGetUri());
	if ($ar[1] == 'woody')
	{
	    $strHome = $bChinese ? 'woody/indexcn.html' : 'woody/index.html';
	    $strImage = 'img src=/woody/image/image.jpg alt="Woody Home Page" /';
	}
	else
	{
	    $strHome = $bChinese ? 'indexcn.html' : 'index.html';
	    $strImage = 'img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /';
	}
    
    echo <<<END
        <div id="banner">
            <div class="logo"><a href="/$strHome"><$strImage></a></div>
            <div class="blue"></div>
        </div>

        <script type="text/javascript">
			var width = window.screen.width;
			document.cookie="screen="+width;
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

function LayoutTopLeft($callback, $bChinese)
{
    EchoAnalyticsOptimize();
//    EchoAnalytics();
    if (!LayoutIsMobilePhone())
    {
        _layoutBanner($bChinese);
        
        $iWidth = LayoutScreenWidthOk();
        _layoutAboveMenu($iWidth);
        call_user_func($callback, $bChinese);
        _layoutBelowMenu($iWidth);
    }
}

function _layoutTail($iWidth, $bMobile, $bChinese, $bAdsense = true)
{
    if ($bMobile == false)
    {
    	if ($iWidth)
    	{
    		echo '</td><td width=15 valign=top>&nbsp;</td><td valign=top>';
    		if ($bAdsense)
    		{
    			AdsenseLeft();
    		}
    		else
    		{
    			LayoutMyPromotion();
    			LayoutWeixinPromotion();
    			LayoutQQgroupPromotion();
    		}
    	}
        echo '</td></table>';
//        echo '    </div>';
//        echo '</div>';
    }
    EchoCopyRight($bMobile, $bChinese);
}

function LayoutTail($bChinese = true)
{
	_layoutTail(LayoutScreenWidthOk(), LayoutIsMobilePhone(), $bChinese, false);	// According to google policy, do NOT show Adsense in pages with no contents, such as input pages
}

function LayoutTailLogin($bChinese = true)
{
    VisitorLogin($bChinese);
    
    $iWidth = LayoutScreenWidthOk();
    $bMobile = LayoutIsMobilePhone();
	if ($bMobile || ($iWidth == false))
	{
		AdsenseWoodyBlog();
	}    
	_layoutTail($iWidth, $bMobile, $bChinese);
}

?>
