<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
 	$strFuturesPremium = GetBlogPictureParagraph(20200424, 'ImgBelieveMe', $bChinese);
	
    echo <<<END
$strSnowball
$strFuturesPremium
END;
}

?>
