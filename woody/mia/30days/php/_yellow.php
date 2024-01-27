<?php
require_once('_30days.php');

function EchoAll($bChinese)
{
	$strYellowAll = PhotoMiaYellowAll($bChinese);
	$strYellow = PhotoMiaYellow($bChinese);
	$strYellowHalf = PhotoMiaYellowHalf($bChinese);
	$strYellowFull = PhotoMiaYellowFull($bChinese);
	$strYellowTired = PhotoMiaYellowTired($bChinese);
	$strYellowUnhappy = PhotoMiaYellowUnhappy($bChinese);
	$strYellowLeft = PhotoMiaYellowLeft($bChinese);
	$strYellowRight = PhotoMiaYellowRight($bChinese);
	$strYellowBetter = PhotoMiaYellowBetter($bChinese);
	$strYellowTooMuch = PhotoMiaYellowTooMuch($bChinese);
	$strYellowNoFlower = PhotoMiaYellowNoFlower($bChinese);
	$strYellowConfused = PhotoMiaYellowConfused($bChinese);
	$strYellowProtesting = PhotoMiaYellowProtesting($bChinese);
	
    echo <<<END
$strYellowAll
$strYellow
$strYellowHalf
$strYellowFull
$strYellowTired
$strYellowUnhappy
$strYellowLeft
$strYellowRight
$strYellowBetter
$strYellowTooMuch
$strYellowNoFlower
$strYellowConfused
$strYellowProtesting
END;
}

?>
