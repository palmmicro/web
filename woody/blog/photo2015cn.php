<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2015年网络日志中使用的图片列表和日志链接。包括经典测试图像Lenna部分原始图片等。';
}

function EchoAll()
{
	$strLenna = ImgCompleteLenna();
	$strSZ162411 = GetLinkElement('华宝油气', 'entertainment/20150818cn.php');

    echo <<<END
<p>8月18日 {$strSZ162411}净值估算的PHP程序
$strLenna
</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
