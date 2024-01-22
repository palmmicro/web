<?php
require_once('_30days.php');

function EchoAll($bChinese)
{
	$strBlueAll = PhotoMiaBlueAll($bChinese);
	$strBlue = PhotoMiaBlue($bChinese);
	$strBlueHalf = PhotoMiaBlueHalf($bChinese);
	$strBlueFull = PhotoMiaBlueFull($bChinese);
	$strBlueYawning = PhotoMiaBlueYawning($bChinese);
	$strBlueGazing = PhotoMiaBlueGazing($bChinese);

    echo <<<END
$strBlueAll
$strBlue
$strBlueHalf
$strBlueFull
$strBlueYawning
$strBlueGazing
END;
}

?>
