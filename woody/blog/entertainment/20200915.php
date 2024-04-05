<?php
require_once('php/_entertainment.php');

function GetMetaDescription($bChinese)
{
	return 'My second live broadcasts on Snowball: Recent trading of SZ161130 tracking Nasdaq 100, with enhanced text and video playback.';
}

function EchoAll($bChinese)
{
	$strSZ162411 = GetBlogLink(20150818, $bChinese);
	$strImgQqq = ImgAutoQuote(PATH_BLOG_PHOTO.'20200915QQQ.jpg', 'Sep 11. Top 10 holdings on QQQ official website.', $bChinese);
	$strGoogle = GetBlogLink(20110509, $bChinese);
	$strImgMnq = ImgAutoQuote(PATH_BLOG_PHOTO.'20200915MNQ.jpg', 'Sep 14. MNQ quotes displayed on CME official website.', $bChinese);
	$strVideo = VideoSZ161130($bChinese);

	EchoBlogDate();
    echo <<<END
<br />Just like the last time, the Snowball staff always asked me to do live broadcasts when my $strSZ162411 was losing money. 
However I did not like the idea of showing misfortune repeatly, so I suggested the topic of recent trading of SZ161130 tracking Nasdaq 100, which I did not participated in but observed carefully with great interest. 
The video of the live broadcast on September 11 is at the bottom. The lecture was not done very well. The Nasdaq content I prepared was finished in just twenty minutes, and then basically went back to talking about oil and gas again. 
This article is an enhanced text version, updated with the latest data.
<br />The US stock market index codes are a mess. The symbol for the Nasdaq 100 on Snowball is .NDX, while the symbol on YAHOO is ^NDX. Usually everyone thinks it represents US technology stocks. 
In fact, a more accurate classification is an index weighted by market capitalization of the 100 largest companies excluding financial companies. There are many ETFs tracking it. The most popular ones include QQQ 1-time long, PSQ 1-time short, TQQQ 3-times long, SQQQ 3-times short, etc. 
$strImgQqq
<br />The index is very popular. It can be seen from the proportion of the top 10 holdings on the QQQ official website on Sep 11 that they are all high-tech companies that the people like. 
Among them, GOOGL and GOOG are actually both $strGoogle. The sum of the two is 3.64+3.56=7.2%, ranking fourth after Apple, Amazon and Microsoft. Tesla, whose stock price has soared several times this year, is currently ranked sixth, surpassing the previous NVDA, which has soared due to AI.
$strImgMnq
<br />The futures corresponding to the index include NQ and MNQ of CME Group. The value of NQ is ten times that of MNQ. Speaking of which, MNQ is also an innovation created by CME Group this year with negative oil prices, so that more mini investors can participate in stock index futures trading.
One order of MNQ is calculated based on the current index points multiplied by 2 US dollars. The current value is more than 20,000 US dollars, a leverage of about 20 times.
<br />There are also many funds tracking the index in Chinese market. In addition to 161130, there are SH513100 and SZ159941 ect.
$strVideo
</p>
END;
}

require('../../../php/ui/_disp.php');
?>
