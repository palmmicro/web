<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('class/Mobile_Detect.php');

define('DEFAULT_DISPLAY_WIDTH', 900);
define('MIN_SCRREN_WIDTH', DEFAULT_DISPLAY_WIDTH + 15 + DEFAULT_ADSENSE_WIDTH);		// 隔15个像素再显示最右边的广告, 见下面width=15

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
        <p>觉得这个网站有用? 可以用支付宝或者微信打赏支持一下.
        <br /><img src=/woody/image/alipay.jpg alt="QRcode to pay Woody in Taobao" />
        <br /><img src=/woody/image/wxpay.jpg alt="QRcode to pay 1 RMB to Woody in Weixin" />
        </p>
END;
}

function LayoutBrokerPromotion()
{
	$strSnowball = GetXueqiuIdLink('7489073227', '技术支持');
	if (AcctIsAdmin())		$strSnowball .= ' '.GetExternalLink('https://www.snowballsecurities.com/external-channel/invite', '管理');
	
    echo <<<END
        <p>低风险文艺券商, 套利神器. 
        <br />★场内基金申购全部一折, 场外app申购大部分1折.
        <br />★场内赎回, 老分级基金公司取走后, 剩余部分5折, 新基金按基金新规执行.
        <br />★赎回资金预解冻, 比正常赎回提前一天资金到账, 提高资金利用率.
        <br />★可转债交易, 费率不会让你失望. 
        <br />★具体详情可以咨询qq: 2531998595
        <br /><img src=/woody/image/yinheaccount.png alt="Yinhe open account scan QR code, agent qq: 2531998595" />
        
        <br /><a href="https://m.zhangle.com/h5Account/mobile-h5/index.htm?ly=HTC1-9000008608&param1=011979" target=_blank>华泰证券开户</a>
        <br />佣金股票万1.6, 场内基金万1, 债券十万分之一. 客户支持微信号18651870837. 
        扫码开户后在第一步显示佣金的地方一定要核对工号<b>011979</b>
        <br /><img src=/woody/image/huataiaccount.png alt="Huatai open account scan QR code, agent id 011979" />
        
        <br /><a href="https://www.snowballsecurities.com/ib-account-open/web?r=50001003008" target=_blank>雪盈证券开户</a>
        	  <a href="https://www.snowballsecurities.com/activity/bank-card-booking?r=50001003008" target=_blank>雪盈境外卡开户</a>
        <br />雪盈证券(Snowball Securities)是新西兰金融注册服务商, 雪球集团成员企业. 
        	  通过强大的互联网科技和雄厚的金融实力, 为全球华人提供包括港股, 美股和中国A股在内的全球证券经纪服务.
        	  为您提供极具市场竞争力的佣金和融资利率, 支持全球交易品类, 毫秒级的下单速度, 免费实时行情, 交易时段专属中文客服服务.
        <br />美股佣金$0.002/股, 最低$0.99/笔. 平台使用费$0.003/股, 最低$1.00/笔.  $strSnowball
        <br /><img src=/woody/image/xueyingaccount.png alt="Xueying open account scan QR code" />
        <br /><img src=/woody/image/xueying_s.jpg alt="Xueying security banner" />
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
//    EchoAnalytics();
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
    			LayoutMyPromotion();
    			LayoutWeixinPromotion();
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
