<?php
require_once('php/_photo30days.php');

function EchoAll($bChinese)
{
	$strBlue = PhotoMiaBlue($bChinese, Get30DaysLink('blue', $bChinese));
	$strBluePuppy = PhotoMiaBluePuppy($bChinese);
	$strRed = PhotoMiaRed($bChinese, Get30DaysLink('hat', $bChinese));
	$strWhite = PhotoMiaWhite($bChinese);
	$strWhiteFull = PhotoMiaWhiteFull($bChinese);
	$strCrown = PhotoMiaCrown($bChinese, Get30DaysLink('crown', $bChinese));
	$strCrownMom = PhotoMiaCrownMom($bChinese);
	
    echo <<<END
$strBlue
$strBluePuppy
$strRed
$strWhite
$strWhiteFull
$strCrown
$strCrownMom

<p>Dress in yellow knit with pink flower. <a href="30days/large/knit_flower7.jpg" target=_blank>Large</a> <a href="30days/yellow.php">More</a>
<br /><img src=30days/knit_flower7.jpg alt="Sapphire Lin dress in yellow knit with pink flower." /></p>

<p>With puppy. <a href="30days/large/leopard_puppy2.jpg" target=_blank>Large</a> <a href="30days/leopard.php">More</a>
<br /><img src=30days/leopard_puppy2.jpg alt="Sapphire Lin with puppy." /></p>

<p>On Mom's back. <a href="30days/large/leopard_mom4.jpg" target=_blank>Large</a>
<br /><img src=30days/leopard_mom4.jpg alt="Sapphire Lin on Mom's back." /></p>

<p>In red hat and red dot dress. <a href="30days/large/red.jpg" target=_blank>Large</a>
<br /><img src=30days/red.jpg alt="Sapphire Lin in red hat and red dot dress." /></p>

<p>Feet in Mom's hands. <a href="30days/large/feet_mom.jpg" target=_blank>Large</a>
<br /><img src=30days/feet_mom.jpg alt="Sapphire Lin's feet in Mom's hands." /></p>

<p>Hand in Mom and Dad's hands. <a href="30days/large/hand_mom_dad2.jpg" target=_blank>Large</a>
<br /><img src=30days/hand_mom_dad2.jpg alt="Sapphire Lin's hand in Mom and Dad's hands." /></p>
END;
}

require('../../php/ui/_disp.php');
?>
