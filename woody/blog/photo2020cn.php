<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2020年网络日志中使用的图片列表和日志链接。包括没醉倒地铁中的2020雪球之夜等。';
}

function EchoAll()
{
	$strSnowball = GetBlogPictureParagraph(20201205, 'ImgSnowballCarnival');
	
    echo <<<END
$strSnowball
END;
}

require('../../php/ui/_dispcn.php');
?>
