<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2016年网络日志中使用的图片列表和日志链接。包括Palmmicro微信公众号sz162411小狐狸二维码等。';
}

function EchoAll()
{
	$strWechat = GetBlogPictureParagraph(20161014, 'ImgPalmmicroWechat');

    echo <<<END
$strWechat
END;
}

require('../../php/ui/_dispcn.php');
?>
