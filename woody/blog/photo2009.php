<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2009 blog. Including photo of the cheapest PSTN phone case in China market etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Sep 27 <a href="pa6488/20090927.php">From PA1688 to PA6488 - Safe Mode Recovery</a>
<br /><img src=../../pa1688/user/g1681/back.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway back view." /></p>

<p>Aug 8 <a href="pa6488/20090808.php">From PA1688 to PA6488 - Ping Response Time</a>
<br /><img src=../../pa1688/user/pb35/m12l16161a.jpg alt="ESMT 1Mx16-bit SDRAM chip on China Roby PB-35 IP phone inside PCB board." /></p>

<p>Feb 17 <a href="ar1688/20090217.php">Low Cost Phone</a>
<br /><img src=photo/20090217.jpg alt="the cheapest PSTN phone case in China market." /></p>
END;
}

require('/php/ui/_disp.php');
?>
