<?php
require('php/_blogtype.php');

function EchoMetaDescription($bChinese)
{
	echo 'List of all Woody blogs about Palmmicro company. Including Palmmicro wechat public account sz162411 etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Oct 14, 2016 Palmmicro <a href="palmmicro/20161014.php">Wechat Public Account</a> sz162411
<br />March 7, 2016 <a href="palmmicro/20160307.php">The Backup of Dynamic DNS palmmicro.ddns.us</a>
<br />Sep 9, 2010 <a href="palmmicro/20100909.php">Forgot Password?</a>
<br />Apr 27, 2010 <a href="palmmicro/20100427.php">The Blocking History of Palmmicro.com</a>
<br />Nov 14, 2009 <a href="palmmicro/20091114.php">Palmmicro MAC Address</a>
<br />March 26, 2008 The History of <a href="palmmicro/20080326.php">Palmmicro</a>.com Domain
<br />Nov 23, 2006 <a href="palmmicro/20061123.php">The Untold Story of Jan, Sing and Wang (Translation)</a>
</p>
<p><img src=/res/logo/palmmicro.jpg alt="Original palmmicro logo designed by Chi-Shin Wang." /></p>
END;
}

require('/php/ui/_disp.php');
?>
