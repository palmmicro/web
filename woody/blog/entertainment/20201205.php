<?php
require_once('php/_entertainment.php');

function GetMetaDescription($bChinese)
{
	return 'On the 2020 Snowball Carnival, while waiting for the free dinner, I promised a homework for Snowball private equity.';
}

function EchoAll($bChinese)
{
	$strStock = GetBlogLink(20141016, $bChinese);
	$strImage = ImgSnowballCarnival($bChinese);
	
	EchoBlogDate($bChinese);
    echo <<<END
<br />The 2020 Snowball Carnival was extremely popular, and the off-site promotional activities were much more than before.
From those booths I collected two cans of Pepsi and a snowball journey workbook, printed a photo, and tried the three-coin chance at the claw machine, but in the end I only got one mask.
<br />When I arrived at the Snowball Private Equity booth, the staff told me that I could draw a lottery. I selected three private equity cards, and the total $strStock investment return rate exceeded 200%, winning the second prize.
Unfortunately, the second prize was running out of stock. She said she could give me two third-prize eye masks or mail me the second-prize pillow.
<br />I asked if I can get a first-prize T-shirt? She asked have you ever bought Snowball Private Equity? I said I can't answer this question, otherwise you would definitely not give me the prize.
<br />She then asked, can you post an article about Snowball Private Equity on Snowball website? I said of course. Probably because I answered so quickly, she continued to ask, did you have any fans? I said of course. Then she waited for me to post live.
<br />Then I saw something wrong, I explained that I didn't have the Snowball software installed on my phone at once. She was confused, how did a person without Snowball software come in? 
At first I planned to tell her that I picked up a badge in the trash can outside of the door, but I felt that this would not be conducive to me getting the first prize. 
So I changed my excuse and said that I was an extremely heavy user of Snowball, the phone software really affected my eyesight and sleep, so I was forced to uninstall it. My honest face probably impressed her, and she finally agreed.
<br />Finally it was my turn to ask questions, and I asked if I could take a photo to use as the cover of post. As soon as they heard my request, all three pretty girls hid aside, so there was no picture of pretty girl in this article.
<br />
$strImage
</p>
END;
}

require('../../../php/ui/_disp.php');
?>
