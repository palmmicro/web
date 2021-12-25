<?php
require('php/_blogtype.php');

function EchoMetaDescription($bChinese)
{
	echo 'List of all Woody entertainment blogs. Mostly are about software programming, including web development and using Adsense to make money.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>June 15, 2016 EastMoney <a href="entertainment/20160615.php">USDCNY Reference Rate</a> Data Interface
<br />Dec 25, 2015 The Interpretation of <a href="entertainment/20151225.php">Sina Stock Data</a> Interface
<br />Aug 18, 2015 PHP Application to Estimate <a href="entertainment/20150818.php">SZ162411 Net Value</a>
<br />Dec 4, 2014 The Origin of <a href="entertainment/20141204.php">Sapphire Lin</a>
<br />Oct 16, 2014 Rules for Giant Chinese State-owned <a href="entertainment/20141016.php">Stock</a>
<br />June 15, 2014 Upgrade to <a href="entertainment/20140615.php">Visual Studio</a> 2013
<br />Aug 11, 2012 Eroda Z1 <a href="entertainment/20120811.php">GPS</a>
<br />July 19, 2012 My First Embedded <a href="entertainment/20120719.php">Linux</a> Application
<br />March 29, 2012 <a href="entertainment/20120329.php">Expo Professionals</a>
<br />June 8, 2011 <a href="entertainment/20110608.php">WiFi</a> Ethernet Bridge
<br />May 9, 2011 <a href="entertainment/20110509.php">Google</a> AdSense
<br />March 23, 2011 <a href="entertainment/20110323.php">VoIP</a> Loser's Songs
<br />Nov 7, 2010 Moving Blog - GB18030 and <a href="entertainment/20101107.php">GB2312</a>
<br />Sep 5, 2010 My First <a href="entertainment/20100905.php">PHP</a> Application
<br />July 26, 2010 <a href="entertainment/20100726.php">Raw Video Viewers</a>
<br />May 29, 2010 My First <a href="entertainment/20100529.php">Visual C++</a> 2008 Application
<br />Feb 19, 2009 From Palmmicro to <a href="entertainment/20090219.php">CSR</a> in Ten Years
<br />Aug 13, 2007 Around the World in 50 Days Paid by <a href="entertainment/20070813.php">SiRF</a>
</p>
<p><img src=../image/mylife.jpg alt="the exact description of my entertainment life" />
<br /><img src=../myphoto/2005/sleeping_s.jpg alt="while you were sleeping" /></p>
END;
}

require('/php/ui/_disp.php');
?>
