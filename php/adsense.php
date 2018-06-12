<?php

function AdsenseSearchEngine($bChinese)
{
	$strSearch = $bChinese ? '搜索' : 'Search';
	
    echo <<< END
<form action="http://www.google.com" id="cse-search-box" target="_blank">
  <div>
    <input type="hidden" name="cx" value="partner-pub-7413337917168353:hzytn0yyhjv" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="63" />
    <input type="submit" name="sa" value="$strSearch" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
END;
}

function AdsenseAuto()
{
    echo <<< END
<div>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
    	 (adsbygoogle = window.adsbygoogle || []).push({
        	  google_ad_client: "ca-pub-7413337917168353",
        	  enable_page_level_ads: true
          });
    </script>
</div>
END;
}

function AdsenseUnit($strWidth, $strHeight, $strUnit, $strSlot)
{
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
/*
function AdsensePalmmicro()
{
	AdsenseUnit('728px', '90px', 'Palmmicro', '6869455571');
}
*/

function AdsenseLeft()
{
	AdsenseUnit('160px', '600px', 'Left', '2492639509');
}

function AdsensePalmmicroUser()
{
	AdsenseUnit('320px', '100px', 'Palmmicro User', '4158164773');
}

function AdsenseWoodyBlog()
{
	AdsenseUnit('300px', '250px', "Woody's blog", '6567638260');
}

function AdsenseBtbond()
{
	AdsenseUnit('336px', '280px', 'Btbond', '3712669579');
}

function AdsenseCatEyes()
{
	AdsenseUnit('336px', '280px', 'CatEyes', '7606315576');
}

function AdsenseSapphire()
{
	AdsenseUnit('320px', '100px', 'Sapphire', '7682733977');
}

function _CompanyAds($strCompany)
{
	if ($strCompany == 'btbond')
	{
		AdsenseBtbond();
	}
	else if ($strCompany == 'cateyes')
	{
		AdsenseCatEyes();
	}
	else
	{
		AdsenseWoodyBlog();
	}
}

function AdsenseCompanyAds()
{
    $ar = explode('/', UrlGetUri());
	if ($ar[1] == 'woody')
	{
		if ($ar[2] == 'res')
		{
		    if (strpos($ar[3], '.') > 0)
		    {
			    _CompanyAds(UrlGetTitle());
		    }
		    else
		    {
			    _CompanyAds($ar[3]);
		    }
		}
		else if ($ar[2] == 'sapphire')
		{
			AdsenseSapphire();
		}
		else
		{
			AdsenseWoodyBlog();
		}
	}
	else
	{
	    AdsensePalmmicroUser();
	}
}

?>
