<?php 
require('php/_blogphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2016年网络日志中使用的图片列表和日志链接. 包括Palmmicro微信公众号sz162411二维码, XOP和华宝油气套利交易仓位和成本在2016年第一天的抓屏图等.';
}

function EchoAll()
{
    echo <<<END
<p>10月14日 Palmmicro<a href="palmmicro/20161014cn.php">微信公众号</a>sz162411
<br /><img src=../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>
END;
}

require('/php/ui/_dispcn.php');
?>
