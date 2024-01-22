<?php
require_once('php/_photo30days.php');

function EchoAll()
{
	$strBlue = PhotoMiaBlue(true, Get30DaysLink('blue'));
	$strBluePuppy = PhotoMiaBluePuppy();
	$strRed = PhotoMiaRed(true, Get30DaysLink('hat'));
	$strWhite = PhotoMiaWhite();
	$strWhiteFull = PhotoMiaWhiteFull();
	$strCrown = PhotoMiaCrown(true, Get30DaysLink('crown'));
	$strCrownMom = PhotoMiaCrownMom();
	
    echo <<<END
$strBlue
$strBluePuppy
$strRed
$strWhite
$strWhiteFull
$strCrown
$strCrownMom

<p>黄色毛衣和粉色小花.<a href="30days/large/knit_flower7.jpg" target=_blank>放大</a> <a href="30days/yellowcn.php">更多</a>
<br /><img src=30days/knit_flower7.jpg alt="Sapphire Lin dress in yellow knit with pink flower." /></p>

<p>跟来福合影.<a href="30days/large/leopard_puppy2.jpg" target=_blank>放大</a> <a href="30days/leopardcn.php">更多</a>
<br /><img src=30days/leopard_puppy2.jpg alt="Sapphire Lin with puppy." /></p>

<p>趴妈妈背上.<a href="30days/large/leopard_mom4.jpg" target=_blank>放大</a>
<br /><img src=30days/leopard_mom4.jpg alt="Sapphire Lin on Mom's back." /></p>

<p>小红帽和红点衣.<a href="30days/large/red.jpg" target=_blank>放大</a>
<br /><img src=30days/red.jpg alt="Sapphire Lin in red hat and red dot dress." /></p>

<p>脚放妈妈手中.<a href="30days/large/feet_mom.jpg" target=_blank>放大</a>
<br /><img src=30days/feet_mom.jpg alt="Sapphire Lin's feet in Mom's hands." /></p>

<p>手放爸爸妈妈手中.<a href="30days/large/hand_mom_dad2.jpg" target=_blank>放大</a>
<br /><img src=30days/hand_mom_dad2.jpg alt="Sapphire Lin's hand in Mom and Dad's hands." /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
