<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
	
    echo <<<END
$strSnowball
END;
}

?>
