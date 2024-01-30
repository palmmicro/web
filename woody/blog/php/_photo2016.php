<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
	$strWechat = GetBlogPictureParagraph(20161014, 'ImgPalmmicroWechat', $bChinese);
	
    echo <<<END
$strWechat
END;
}

?>
