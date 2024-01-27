<?php
require_once('_30days.php');

function EchoAll($bChinese)
{
	$strLeopardAll = PhotoMiaLeopardAll($bChinese);
	$strLeopard = PhotoMiaLeopard($bChinese);
	$strLeopardPuppy = PhotoMiaLeopardPuppy($bChinese);
	$strLeopardClose = PhotoMiaLeopardClose($bChinese);
	$strLeopardSmile = PhotoMiaLeopardSmile($bChinese);
	$strLeopardTired = PhotoMiaLeopardTired($bChinese);
	$strLeopardHalf = PhotoMiaLeopardHalf($bChinese);
	
    echo <<<END
$strLeopardAll
$strLeopard
$strLeopardPuppy
$strLeopardClose
$strLeopardSmile
$strLeopardTired
$strLeopardHalf
END;
}

?>
