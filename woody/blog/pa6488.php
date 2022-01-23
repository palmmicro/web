<?php
require('php/_blogtype.php');

function GetMetaDescription($bChinese)
{
	return 'The list of Woody PA6488 related blogs. Including chip introduction, solution details and lessons of software API for 3rd party development etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Nov 20, 2011 <a href="pa6488/20111120.php">From PA1688 to PA6488 - Ethernet PHY Ready?</a>
<br />May 24, 2011 <a href="pa6488/20110524.php">H.263 Compatibility</a>
<br />May 16, 2011 <a href="pa6488/20110516.php">JPEG Story</a>
<br />Apr 11, 2011 <a href="pa6488/20110411.php">From PA1688 to PA6488 - UART Function in Product Evolution</a>
<br />Dec 25, 2010 <a href="pa6488/20101225.php">EFSL File System</a>
<br />Dec 13, 2010 <a href="pa6488/20101213.php">From PA1688 to PA6488 - G.729 Test Vectors</a>
<br />Feb 11, 2010 <a href="pa6488/20100211.php">From PA1688 to PA6488 - Software API License Terms</a>
<br />Jan 9, 2010 <a href="pa6488/20100109.php">From PA1688 to PA6488 - Web Interface</a>
<br />Sep 27, 2009 <a href="pa6488/20090927.php">From PA1688 to PA6488 - Safe Mode Recovery</a>
<br />Sep 1, 2009 <a href="pa6488/20090901.php">From PA1688 to PA6488 - TFTP Performance</a>
<br />Aug 25, 2009 <a href="pa6488/20090825.php">From PA1688 to PA6488 - Upgrade Software Size</a>
<br />Aug 19, 2009 <a href="pa6488/20090819.php">PA648C Video Compression Module</a>
<br />Aug 16, 2009 <a href="pa6488/20090816.php">From PA1688 to PA6488 - Upgrade Software Name</a>
<br />Aug 11, 2009 <a href="pa6488/20090811.php">From PA1688 to PA6488 - Software Working Directory</a>
<br />Aug 8, 2009 <a href="pa6488/20090808.php">From PA1688 to PA6488 - Ping Response Time</a>
</p>
<p><img src=photo/20110606.jpg alt="PA6488 and X-Lite fish demo screenshot" /></p>
END;
}

require('/php/ui/_disp.php');
?>
