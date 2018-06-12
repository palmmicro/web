<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('copyright.php');
require_once('analytics.php');
require_once('adsense.php');
require_once('class/Mobile_Detect.php');

define ('MIN_SCRREN_WIDTH', 1280);
define ('DEFAULT_DISPLAY_WIDTH', 900);

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
	{
		$iWidth = intval($strWidth);
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
END;
}

function _layoutAboveMenu()
{
	$iWidth = LayoutScreenWidthOk();
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

function _layoutBelowMenu()
{
	if ($iWidth = LayoutScreenWidthOk())		$strExtra = 'width='.strval($iWidth - MIN_SCRREN_WIDTH + DEFAULT_DISPLAY_WIDTH);
	else 										$strExtra = '';
	
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
        _layoutAboveMenu();
        call_user_func($callback, $bChinese);
        _layoutBelowMenu();
    }
}

function LayoutTail($bChinese)
{
    $bMobile = LayoutIsMobilePhone(); 
    if ($bMobile == false)
    {
    	if (LayoutScreenWidthOk())
    	{
    		echo '</td><td valign=top>';
//    		AdsenseCompanyAds();
//			AdsenseAuto();
    		AdsenseLeft();
    	}
        echo '</td></table>';
//        echo '    </div>';
//        echo '</div>';
    }
    EchoCopyRight($bMobile, $bChinese);
}

function LayoutTailLogin($bChinese)
{
    VisitorLogin($bChinese);
	if (LayoutIsMobilePhone() || (LayoutScreenWidthOk() == false))
	{
		AdsenseCompanyAds();
	}
    LayoutTail($bChinese);
}

?>
