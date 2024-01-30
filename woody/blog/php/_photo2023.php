<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
 	$strUsdInterest = GetBlogPictureParagraph(20230614, 'ImgCMENQ20230614', $bChinese);
	
    echo <<<END
$strUsdInterest
END;
}

?>
