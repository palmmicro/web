<?php 
require('php/_blogphoto.php');

function EchoAll($bChinese)
{
	$strPalmmicro = GetBlogPictureParagraph(20080326, 'ImgHalfMoonBay', $bChinese);
	
    echo <<<END
<p>Nov 24 <a href="ar1688/20081124.php">Micrel KSZ8842</a>
<br /><img src=../../pa1688/user/hop3003/rtl8305sb.jpg alt="RTL8305SB chip in HOP3003 IP phone."></p>

<p>Aug 6 <a href="pa1688/20080806.php">Non-Standard PA1688 Based Devices</a>
<br /><img src=../../pa1688/user/ke1000/1.jpg alt="Non-standard PA1688 based Koncept KE1000 IP phone front picture." /></p>

<p>Jul 29 <a href="ar1688/20080729.php">Router, PPPoE and DM9003</a>
<br /><img src=../../ar1688/user/gp1266/03.jpg alt="GP1266 IP phone POWER, LAN1 and LAN2 interface." /></p>

<p>Jun 15 <a href="ar1688/20080615.php">A Farewell to RTL8019AS</a>
<br /><img src=../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></p>

$strPalmmicro
END;
}

require('../../php/ui/_disp.php');
?>
