<?php 
require('php/_blogphoto.php');

function EchoAll()
{
	$strLenna = ImgCompleteLenna();
	$strPHP = GetBlogPictureParagraph(20100905, 'ImgPhpBest');
	
    echo <<<END
<p>12月2日 <a href="ar1688/20101202cn.php">烧录程序存储器</a>
<br /><img src=photo/20101202.jpg></p>

<p>9月7日 <a href="pa1688/20100907cn.php">夜以继日瞎忙</a>
<br /><img src=../../pa1688/user/g1681/soyo.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway front view." /></p>

$strPHP

<p>7月26日 <a href="entertainment/20100726cn.php">原始视频播放器</a>
<br /><img src=photo/20100726.jpg alt="Screen shot of Speech Workshop, Raw Image Viewer and CamMan" />
$strLenna
</p>

<p>5月29日 我的第一个<a href="entertainment/20100529cn.php">Visual C++</a> 2008程序
<br /><img src=photo/20100529.jpg alt="Screen shot of My First Visual C++ 2008 Application Woody's Web Tool" /></p>

<p>4月27日 <a href="palmmicro/20100427cn.php">记录Palmmicro.com的被屏蔽历史</a>
<br /><img src=photo/20100813.jpg alt="Beijing Simatai part of the Great Wall of China" /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
