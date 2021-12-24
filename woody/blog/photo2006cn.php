<?php
require('php/_blogphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2006年网络日志中使用的图片列表和日志链接. 包括跟写华人VoIP鼻祖Chi-Shin Wang原文的ATCOM老孙和李敬在纽约中央公园的合影等.';
}

function EchoAll()
{
    echo <<<END
<p>11月23日 <a href="palmmicro/20061123cn.php">Jan, Sing和Wang不得不说的故事 - VoIP华人鼻祖</a>
<br /><img src=../groupphoto/customer/laosun.jpg alt="Li Jing, Sun Yanhong and me in central park, NYC." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
