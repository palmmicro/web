<?php
require_once('php/_entertainment.php');

function GetMetaDescription($bChinese)
{
	return 'Use arbitrage dollar interest to explain Nasdaq 100 and S&P 500 futures premium. Market pricing is always efficient.';
}

function EchoAll($bChinese)
{
	$strImage = ImgCMENQ20230614($bChinese);
	
	EchoBlogDate($bChinese);
    echo <<<END
<br />As SZ159501 ETF starts trading today, the Nasdaq 100 funds on the Chinese market have reached the edge of being counted on both hands, and half of them are newly opened this year, which shows its popularity.
<br />The realtime netvalue estimation of these funds uses futures NQ from Sina data. Sina's futures data always provides the so-called main contract, which means it may switch earlier. 
For example, according to NQ data, Sina switched to contracts expiring in September two days earlier. In the past year, whenever this happens, someone always asks, why is the realtime netvalue estimation so high?
<br />Because as the USD raises interest rates, the futures premium of the Nasdaq 100 and S&P 500 have continued to rise.
$strImage
</p>
<p>This is a screenshot as best I could before writing it. CME data is delayed by ten minutes, Snowball data is basically realtime. 
It can be seen that the contract settled on June 16 (14983) has only a small premium compared to the market price (about 14980 ten minutes ago), but the September contract has a premium of about 1.2% compared to June (15169/14983=1.012).
December also had the same premium of 1.2% relative to September.
<br />Everyone likes to say that futures reflect expectations, so this premium can easily be interpreted as the public believing that US stocks will always rise, but this is wrong. 
Just like the relationship between the crude oil futures premium and tanker freight rates that I wrote in 2020, the premium reflects the game between arbitrageurs.
<br />Let's do the math specifically. If you hold a long position in QQQ, you can exchange it for the NQ contract three months later. Because the futures will not receive dividends, you will lose about 50 cents per share in dividends in a few days, which is 0.014%.
But at a US dollar interest rate of 5%, the cash released from QQQ can earn 1.25% interest in three months. Of course, because the NQ contract also takes up about 3.4% of cash, this interest should be adjusted to 1.201%, and the income after deducting dividend losses is 1.187%. 
In other words, if NQ does not have a premium, then all those holding QQQ can use NQ instead, and then earn 1.187% more interest every three months. There is no free lunch in the world. The result of the arbitrage game is that NQ has a fixed premium of 1.2% every three months.
</p>
END;
}

require('../../../php/ui/_disp.php');
?>
