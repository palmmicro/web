<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2011年网络日志中使用的图片列表和日志链接. 包括ATCOM AT323网络电话内部PCB图像, 测试插值算法的Rie Miyazawa Santa Fe JPEG图片等.';
}

function EchoAll()
{
	$strSantaFe = ImgSantaFe();
	$strGoogle = GetBlogPictureParagraph(20110509, 'ImgWoody20060701');
	
    echo <<<END
<p>11月4日 <a href="pa1688/20111104cn.php">升级老PA168F的步骤</a>
<br /><img src=photo/20111104.jpg></p>

<p>8月14日 <a href="pa1688/20110814cn.php">拯救PA168Q的合理步骤</a>
<br /><img src=photo/20110814.jpg alt="Palmmicro.com visitor overview from Google Analytics on Aug 12, 2011." /></p>

<p>6月8日 Ethernet转<a href="entertainment/20110608cn.php">WiFi</a>
<br /><img src=photo/20110608.jpg alt="WiFi Ethernet bridge WDS settings screenshot." /></p>

<p>5月24日 <a href="pa6488/20110524cn.php">兼容H.263</a>
<br /><img src=photo/20110524.jpg></p>

<p>5月16日 <a href="pa6488/20110516cn.php">JPEG总动员</a>
<br /><img src=photo/20110516.jpg alt="Test interpolation algorithm with Rie Miyazawa Santa Fe JPEG file." />
$strSantaFe
</p>

$strGoogle

<p>4月20日 <a href="pa1688/20110420cn.php">额的神啊! AT323话机居然LM386一直在工作! </a>
<br /><img src=../../pa1688/user/at323/whitepcb_s.jpg alt="ATCOM IP PHONE AT323 internal PCB image." /></p>

<p>4月11日 <a href="pa6488/20110411cn.php">从PA1688到PA6488 - 产品演化过程中的串口功能</a>
<br /><img src=photo/20111127.jpg alt="PA6488 and X-Lite fish demo via WiFi Ethernet bridge." /></p>

<p>2月25日 <a href="pa1688/20110225cn.php">PA1688设备杀手</a>
<br /><img src=photo/20110225.jpg></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
