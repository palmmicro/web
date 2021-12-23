<?php 
require('php/_blogphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2012年网络日志中使用的图片列表和日志链接. 包括丹麦用户拍摄的Palmmicro AR168R RoIP模块照片, 使用CSR芯片的E路航Z1 GPS的照片等.';
}

function EchoAll()
{
    echo <<<END
<p>11月11日 <a href="ar1688/20121111cn.php">找出两幅图不同之处</a>
<br /><img src=photo/20121111.jpg alt="Standard AR168R RoIP module photo by an user from Denmark." /></p>

<p>8月11日 E路航Z1 <a href="entertainment/20120811cn.php">GPS</a>
<br /><img src=photo/20120811.jpg alt="Eroda Z1 GPS and package." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
