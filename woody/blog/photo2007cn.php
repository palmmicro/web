<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2007年网络日志中使用的图片列表和日志链接. 包括一个基于Infineon 21553芯片的网络电话上使用的典型的PA1688 00-09-45 MAC地址等.';
}

function EchoAll()
{
    echo <<<END
<p>8月27日 <a href="ar1688/20070827cn.php">如何改MAC地址</a>
<br /><img src=../../pa1688/user/jr168/2s.jpg alt="A typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
