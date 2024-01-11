<?php
require('php/_blogtype.php');

function GetMetaDescription($bChinese)
{
	return 'List of all Woody blogs about Palmmicro company. Including Palmmicro MAC address, story of founder Chi-Shin Wang etc.';
}

function EchoAll($bChinese)
{
	$strWechat = GetBlogTitle(20161014, $bChinese);
	$strPalmmicro = GetBlogTitle(20080326, $bChinese);

    echo <<<END
<p>$strWechat
<br />Sep 9, 2010 <a href="palmmicro/20100909.php">Forgot Password?</a>
<br />Apr 27, 2010 <a href="palmmicro/20100427.php">The Blocking History of Palmmicro.com</a>
<br />Nov 14, 2009 <a href="palmmicro/20091114.php">Palmmicro MAC Address</a>
<br />$strPalmmicro
<br />Nov 23, 2006 <a href="palmmicro/20061123.php">The Untold Story of Jan, Sing and Wang (Translation)</a>
</p>
<p><img src=/res/logo/palmmicro.jpg alt="Original palmmicro logo designed by Chi-Shin Wang." /></p>
END;
}

require('../../php/ui/_disp.php');
?>
