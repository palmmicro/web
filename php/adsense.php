<?php
define('DEFAULT_ADSENSE_WIDTH', 300);

function AdsenseSearchEngine($bChinese = true)
{
	$strSearch = $bChinese ? '搜索' : 'Search';
	
    echo <<< END

<form action="https://www.google.com" id="cse-search-box" target="_blank">
  <div>
    <input type="hidden" name="cx" value="partner-pub-7413337917168353:hzytn0yyhjv" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="63" />
    <input type="submit" name="sa" value="$strSearch" />
  </div>
</form>
<script src="https://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
END;
}

function AdsenseUnit($strUnit, $strSlot, $iHeight, $iWidth = DEFAULT_ADSENSE_WIDTH)
{
	$strHeight = strval($iHeight).'px';
	$strWidth = strval($iWidth).'px';
    echo <<< END

<div>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Ads on $strUnit -->
        <ins class="adsbygoogle"
        style="display:inline-block;width:$strWidth;height:$strHeight"
        data-ad-client="ca-pub-7413337917168353"
        data-ad-slot="$strSlot"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
END;
}

function AdsenseWoodyBlog()
{
	AdsenseUnit("Woody's blog", '6567638260', 250);
}

function AdsenseLeft()
{
	AdsenseUnit('LeftWide', '7644091508', 1050);
}

function AdsensePalmmicroUser()
{
	AdsenseUnit('Palmmicro User', '4158164773', 100);
//	AdsenseUnit('Sapphire', '7682733977', 100, 320);
}

function AdsenseContent()
{
	AdsenseUnit('Content', '3041144501', 300);
}

?>
