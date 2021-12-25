<?php
require('php/_blogtype.php');

function EchoMetaDescription($bChinese)
{
	echo 'The list of Woody PA1688 related blogs. Including chip introduction, solution details and lessons of software API for 3rd party development etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Apr 5, 2014 <a href="pa1688/20140405.php">The Good, the Bad and the Ugly</a>
<br />Feb 10, 2013 <a href="pa1688/20130210.php">Redial Key as Mute Key</a>
<br />Feb 10, 2012 <a href="pa1688/20120210.php">Email Records: the Death of an AudioPlus VOIP616 IP Phone</a>
<br />Nov 13, 2011 <a href="pa1688/20111113.php">The End of IAX2</a>
<br />Nov 4, 2011 <a href="pa1688/20111104.php">Steps to Upgrade an Old PA168F</a>
<br />Aug 14, 2011 <a href="pa1688/20110814.php">The Logical Steps to Rescue a PA168Q</a>
<br />Apr 27, 2011 <a href="pa1688/20110427.php">Software Over-Optimization</a>
<br />Apr 20, 2011 <a href="pa1688/20110420.php">My God the LM386 in AT323 Phone is Working ALL the Time!</a>
<br />Feb 25, 2011 <a href="pa1688/20110225.php">PA1688 Device Killer</a>
<br />Sep 7, 2010 <a href="pa1688/20100907.php">A Hard Day's Night</a>
<br />June 6, 2010 <a href="pa1688/20100606.php">False Alarm</a>
<br />Dec 15, 2009 <a href="pa1688/20091215.php">Mistakes I Made on Last Sunday</a>
<br />Aug 6, 2008 <a href="pa1688/20080806.php">Non-Standard PA1688 Based Devices</a>
<br />June 7, 2007 <a href="pa1688/20070607.php">Too Late Good News</a>
</p>
END;
}

require('/php/ui/_disp.php');
?>
