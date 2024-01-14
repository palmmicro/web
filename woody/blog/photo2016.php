<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2016 blog. Including Palmmicro WeChat public account sz162411 small fox QR code etc.';
}

function EchoAll($bChinese)
{
	$strWechat = GetBlogPictureParagraph(20161014, 'ImgPalmmicroWechat', $bChinese);
	
    echo <<<END
$strWechat
END;
}

require('../../php/ui/_disp.php');
?>
