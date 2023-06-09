<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2015年网络日志中使用的图片列表和日志链接。包括经典测试图像Lenna部分原始图片等。';
}

function EchoAll()
{
	$strLenna = GetHtmlElement('8月18日 '.GetBlogLink(20150818).'净值估算的PHP程序 '.ImgCompleteLenna());

    echo <<<END
$strLenna
END;
}

require('../../php/ui/_dispcn.php');
?>
