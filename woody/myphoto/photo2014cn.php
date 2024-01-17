<?php
require('php/_myphoto.php');

function GetMetaDescription()
{
	return 'Woody的2014年个人图片和相关链接. 包括小雪拍的深圳二四莲1000期活动时在梅林后山晒太阳乐不可支的照片, 和闺女林近岚出生后在医院测试长时间闲置相机的结果.';
}

function EchoAll()
{
	$strMia = GetBlogPictureParagraph(20141204, 'ImgWorriedWoody', true, '小西拍摄于'.GetPhotoDirLink(20141121));
	$strDad = GetPhotoDirLink(20141211).' <a href="../mia/photo30dayscn.php">满月艺术照</a> '.ImgAutoQuote('/woody/image/20141211/IMG_5889.JPG', '跟沾光的爸爸合影');
	
	
    echo <<<END
<p><a href="http://www.doyouhike.net/forum/leisure/1013822,0,0,1.html" target=_blank>1月11日</a>. 梅林后山的阳光. 小雪拍摄 <a href="2014/large/sunshine.jpg" target=_blank>放大</a>
<br /><img src=2014/sunshine.jpg alt="Sunshine on my shoulders in Mei Lin" /></p>

<p>11月16日. 闺女出生后在医院测试长时间闲置的相机. <a href="2014/large/hospital.jpg" target=_blank>放大</a>
<br /><img src=2014/hospital.jpg alt="In the hospital where Sapphire was born" /></p>

$strMia
<p>$strDad</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
