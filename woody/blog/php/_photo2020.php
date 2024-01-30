<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
	
    echo <<<END
$strSnowball
END;
}

?>
