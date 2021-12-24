<?php
require('php/_blogphoto.php');

function EchoMetaDescription($bChinese)
{
	echo 'Pictures from Woody 2016 blog. Including Palmmicro wechat public accouont sz162411 QR code, screen shot of XOP and SZ162411 arbitrage data etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Oct 14 Palmmicro <a href="palmmicro/20161014.php">Wechat Public Account</a> sz162411
<br /><img src=../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>
END;
}

require('/php/ui/_disp.php');
?>
