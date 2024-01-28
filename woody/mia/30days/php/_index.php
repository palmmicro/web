<?php
require_once('_30days.php');

function _get30DaysLink($strPage, $bChinese = true)
{
    return GetPhpLink(PATH_30DAYS.$strPage, false, Get30DaysDisplay($strPage, $bChinese), $bChinese);
}

function EchoAll($bChinese)
{
	$strBlue = PhotoMiaBlue($bChinese, _get30DaysLink('blue', $bChinese));
	$strBluePuppy = PhotoMiaBluePuppy($bChinese);
	$strRed = PhotoMiaRed($bChinese, _get30DaysLink('hat', $bChinese));
	$strWhite = PhotoMiaWhite($bChinese);
	$strWhiteFull = PhotoMiaWhiteFull($bChinese);
	$strCrown = PhotoMiaCrown($bChinese, _get30DaysLink('crown', $bChinese));
	$strCrownMom = PhotoMiaCrownMom($bChinese);
	$strYellow = PhotoMiaYellow($bChinese, _get30DaysLink('yellow', $bChinese));
	$strLeopard = PhotoMiaLeopard($bChinese, _get30DaysLink('leopard', $bChinese));
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
