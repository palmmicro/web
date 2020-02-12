<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('class/Mobile_Detect.php');

define('DEFAULT_DISPLAY_WIDTH', 900);
define('MIN_SCRREN_WIDTH', DEFAULT_DISPLAY_WIDTH + 15 + DEFAULT_ADSENSE_WIDTH);		// 隔15个像素再显示最右边的广告, 见下面width=15

function LayoutQqGroup()
{
	$strWeixin = GetWeixinDevLink();
    echo <<<END
        <p>加入QQ群反馈网站和{$strWeixin}的问题.
        <br /><img src=/woody/image/group7.png alt="QQ group 7 QR code" />
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
        <p>觉得这个网站有用? 可以用微信打赏支持一下.
        <br /><img src=/woody/image/wxpay.jpg alt="QRcode to pay 1 RMB to Woody in Weixin" />
        </p>
END;
}

function LayoutAliPay()
{
    echo <<<END
        <p>觉得这个网站有用? 可以用支付宝打赏支持一下.
        <br /><img src=/woody/image/alipay.jpg alt="QRcode to pay Woody in Taobao" />
        </p>
END;
}

// 或者1700177971(魔女小豌豆4)
function LayoutBrokerYinhe()
{
    echo <<<END
        <p>低风险文艺券商, 套利神器. 
        <br />★场内基金申购全部一折, 场外app申购大部分1折.
        <br />★场内赎回, 老分级基金公司取走后, 剩余部分5折, 新基金按基金新规执行.
        <br />★赎回资金预解冻, 比正常赎回提前一天资金到账, 提高资金利用率.
        <br />★可转债交易, 费率不会让你失望. 
        <br />★具体详情可以咨询QQ: 2531998595(魔女小豌豆3)
        <br /><img src=/woody/image/yinheaccount.png alt="Yinhe open account scan QR code, agent qq: 2531998595" />
        </p>
END;
}

function LayoutBrokerHuatai()
{
	echo <<<END
        <p><a href="https://m.zhangle.com/h5Account/mobile-h5/index.htm?ly=HTC1-9000008608&param1=011979" target=_blank>华泰证券开户</a>
        <br />佣金股票万1.6, 场内基金万1, 债券十万分之一. 客户支持微信号18651870837. 
        扫码开户后在第一步显示佣金的地方一定要核对工号<b>011979</b>
        <br /><img src=/woody/image/huatai20190906.png alt="Huatai open account scan QR code updated on 20190906, agent id 011979" />
        </p>
END;
}

function LayoutBrokerXueying()
{
	$strSnowball = GetXueqiuIdLink('7489073227', '技术支持');
	if (AcctIsAdmin())		$strSnowball .= ' '.GetExternalLink('https://www.snowballsecurities.com/external-channel/invite', '管理');

    echo <<<END
        <p><a href="https://www.snowballsecurities.com/activity/open/open-v10?r=50001003008" target=_blank>雪盈证券开户</a>
        	  <a href="https://www.snowballsecurities.com/activity/bank-card-booking?r=50001003008" target=_blank>雪盈境外卡开户</a>
        <br />雪球旗下港美股券商——雪盈证券, 极低佣金利率, 毫秒级下单速度, 免费实时行情! 
        	  更有开户入金新手豪礼等着你, 最高1066港币+热门股票+高级行情, 点击链接, 开户领豪礼. 
		        $strSnowball
        <br /><img src=/woody/image/xueying.png alt="Xueying security new banner" />
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

function LayoutTopLeft($callback = false, $bSwitchLanguage = false, $bChinese = true)
{
    EchoAnalyticsOptimize();
	$_SESSION['switchlanguage'] = $bSwitchLanguage;
	$_SESSION['mobile'] = $callback ? LayoutIsMobilePhone() : true;
    if ($_SESSION['mobile'] == false)
    {
        _layoutBanner($bChinese);
        
        $iWidth = LayoutScreenWidthOk();
        _layoutAboveMenu($iWidth);
        call_user_func($callback, $bChinese);
        _layoutBelowMenu($iWidth);
    }
}

function _layoutTail($iWidth, $bChinese, $bAdsense = true)
{
    if ($_SESSION['mobile'] == false)
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
    			LayoutWeixinPromotion();
    			LayoutWeixinPay();
    		}
    	}
        echo '</td></table>';
//        echo '    </div>';
//        echo '</div>';
    }
    EchoCopyRight($_SESSION['mobile'], $bChinese);
}

function LayoutTail($bChinese = true)
{
	_layoutTail(LayoutScreenWidthOk(), $bChinese, false);	// According to google policy, do NOT show Adsense in pages with no contents, such as input pages
}

function LayoutTailLogin($bChinese = true)
{
    VisitorLogin($bChinese);
    
    $iWidth = LayoutScreenWidthOk();
	if ($_SESSION['mobile'] || ($iWidth == false))
	{
		AdsenseWoodyBlog();
	}    
	_layoutTail($iWidth, $bChinese);
}

?>
