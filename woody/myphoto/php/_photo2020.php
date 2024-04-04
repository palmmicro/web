<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
	$strNasdaq100 = VideoNasdaq100($bChinese);
	
    echo <<<END
$strSnowball
$strNasdaq100
END;
}

?>
