<?php
require_once('_30days.php');

function EchoAll($bChinese)
{
	$strCrownAll = PhotoMiaCrownAll($bChinese);
	$strCrown = PhotoMiaCrown($bChinese);
	$strCrownSad = PhotoMiaCrownSad($bChinese);
	$strCrownHalf = PhotoMiaCrownHalf($bChinese);
	$strCrownFull = PhotoMiaCrownFull($bChinese);
	
    echo <<<END
$strCrownAll
$strCrown
$strCrownSad
$strCrownHalf
$strCrownFull
END;
}

?>
