<?php 
require('php/_blogphoto.php');

function EchoAll()
{
	$strPalmmicro = GetBlogPictureParagraph(20080326, 'ImgHalfMoonBay');
	
    echo <<<END
<p>11月24日 <a href="ar1688/20081124cn.php">Micrel KSZ8842网络芯片</a>
<br /><img src=../../pa1688/user/hop3003/rtl8305sb.jpg alt="RTL8305SB chip in HOP3003 IP phone."></p>

<p>8月6日 <a href="pa1688/20080806cn.php">非标准PA1688设备</a>
<br /><img src=../../pa1688/user/ke1000/1.jpg alt="Non-standard PA1688 based Koncept KE1000 IP phone front picture." /></p>

<p>7月29日 <a href="ar1688/20080729cn.php">路由器, PPPoE和DM9003</a>
<br /><img src=../../ar1688/user/gp1266/03.jpg alt="GP1266 IP phone POWER, LAN1 and LAN2 interface." /></p>

<p>6月15日 <a href="ar1688/20080615cn.php">告别RTL8019AS</a>
<br /><img src=../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></p>

$strPalmmicro
END;
}

require('../../php/ui/_dispcn.php');
?>
