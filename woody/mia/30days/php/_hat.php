<?php
require_once('_php30days.php');

function EchoAll($bChinese)
{
	$strRedAll = PhotoMiaRedAll($bChinese);
	$strRed = PhotoMiaRed($bChinese);
	$strRedHalf = PhotoMiaRedHalf($bChinese);
	$strRedWondering = PhotoMiaRedWondering($bChinese);
	$strRedLost = PhotoMiaRedLost($bChinese);

    echo <<<END
$strRedAll
$strRed
$strRedHalf
$strRedWondering
$strRedLost
END;
}

?>
