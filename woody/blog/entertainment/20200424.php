<?php
require_once('php/_entertainment.php');

function GetMetaDescription($bChinese)
{
	return 'Using crude oil futures premium since the CME negative oil prices to calculate tanker rates during the corresponding period, market pricing is always effective.';
}

function EchoAll($bChinese)
{
	$strNegOil = ImgAutoQuote(PATH_BLOG_PHOTO.'negoilfuture.jpg', 'Screen shot of CME negative oil future price', false);
	$strTankerRate = ImgAutoQuote(PATH_BLOG_PHOTO.'tanker20200417.jpg', 'Screen shot of tanker rate on Apr 17, 2020.', false);
	$strImage = ImgBelieveMe($bChinese);
	
	EchoBlogDate($bChinese);
    echo <<<END
<br />Understanding this article requires a primary school mathematics graduation level.
<br />Writing articles has never been my strong point. The primary use of writing for me is to organize my thoughts in the process. Therefore, there is little common knowledge here, and more often is some data mining here and there.
<br />When I sharpened my pencil to write crude oil futures premium in the early morning of Mar 6, I was actually using the new high gold-to-oil ratio to convince myself that it was time to buy oil at the bottom.
And at the same time, I reminded myself not to forget the pitfalls I stepped on in early 2016. At the end of the article, it was mentioned that the premium may reflect the cost of storage. 
Today I will do some elementary school-level mathematical calculations on this conclusion.
<br />It feels like a lifetime ago since then. On Mar 6, oil futures CL fell 10% to $40, and then continued to fall 30% to $30 on Mon, Mar 9, and then fell all the way to negative numbers -$37.63.
$strNegOil
<br />Before CME can design a complex number oil price system, this screenshot will be shown to the public again and again as part of a historical portrait.
<br />According to the official explanation of CME, negative oil prices reflect the overproduction of crude oil that cannot be stored, and desperate producers have to pay cash to have the oil removed. 
In this environment, oil tankers have become ideal temporary storage locations, and tanker rate has become storage costs.
$strTankerRate
<br />This picture shows the tanker rates announced on Apr 17. Taking the very large tanker VLCC as an example, the average price for the whole year of 2019 was US$25,600 per day, while the price this week was US$185,700 per day. 
The difference of US$160,000 per day between the two can be regarded as the storage costs used as oil tanks.
<br />As new positions for the May contract can no longer be opened on Apr 20, the premium difference per barrel between the Jun contract and the Oct contract in the screenshot of oil futures CL at that time is:
<br />31.86 - 22.23 = 9.63 USD.
<br />A VLCC can store 2 million barrels of crude oil, in the 120 days covered by the Jun to Oct contract, the daily income is:
<br />9.63 * 2,000,000 / 120 = 160,500 USD
<br />Which is exactly equivalent to the previous tank rate difference.
<br />If I said that I was calculating and writing at the same time, and I only saw this perfect result now, I doubt if anyone would really believe it? A blind cat can really catch a dead mouse!
$strImage
</p>
END;
}

require('../../../php/ui/_disp.php');
?>
