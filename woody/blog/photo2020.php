<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2020 blog. Including Snowball carnival 2020 etc.';
}

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
	
    echo <<<END
$strSnowball
END;
}

require('../../php/ui/_disp.php');
?>
