<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
	$strSnowball = PhotoSnowball($bChinese);
	$strNasdaq100 = VideoNasdaq100($bChinese);
 	$strFuturesPremium = GetBlogPictureParagraph(20200424, 'ImgBelieveMe', $bChinese);
	
    echo <<<END
$strSnowball
$strNasdaq100
$strFuturesPremium
END;
}

?>
