<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2007 blog. Including photo of a typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Aug 27 <a href="ar1688/20070827.php">How to Change MAC Address</a>
<br /><img src=../../pa1688/user/jr168/2s.jpg alt="A typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone." /></p>
END;
}

require('../../php/ui/_disp.php');
?>
