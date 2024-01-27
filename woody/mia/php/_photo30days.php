<?php
require_once('30days/php/_photo.php');
require_once('_mia.php');

function EchoAll($bChinese)
{
	$strBlue = PhotoMiaBlue($bChinese, Get30DaysLink('blue', $bChinese));
	$strBluePuppy = PhotoMiaBluePuppy($bChinese);
	$strRed = PhotoMiaRed($bChinese, Get30DaysLink('hat', $bChinese));
	$strWhite = PhotoMiaWhite($bChinese);
	$strWhiteFull = PhotoMiaWhiteFull($bChinese);
	$strCrown = PhotoMiaCrown($bChinese, Get30DaysLink('crown', $bChinese));
	$strCrownMom = PhotoMiaCrownMom($bChinese);
	$strYellow = PhotoMiaYellow($bChinese, Get30DaysLink('yellow', $bChinese));
	$strLeopard = PhotoMiaLeopard($bChinese, Get30DaysLink('leopard', $bChinese));
	$strLeopardMom = PhotoMiaLeopardMom($bChinese);
	$strRedDot = PhotoMiaRedDot($bChinese);
	$strFeetInHand = PhotoMiaFeetInHand($bChinese);
	$strHandInHand = PhotoMiaHandInHand($bChinese);
	
    echo <<<END
$strBlue
$strBluePuppy
$strRed
$strWhite
$strWhiteFull
$strCrown
$strCrownMom
$strYellow
$strLeopard
$strLeopardMom
$strRedDot
$strFeetInHand
$strHandInHand
END;
}

?>
