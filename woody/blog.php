<?php
require('php/_blog.php');

function GetTitle($bChinese)
{
	return "Woody's Blog";
}

function GetMetaDescription($bChinese)
{
	return "List and classification of all Woody's blogs. Including solution topics of PA1688, AR1688, PA3288 and PA6488, Palmmicro company and my entertainment.";
}

function EchoAll($bChinese)
{
	$strUsdInterest = GetBlogTitle(20230614, $bChinese);
	$strSnowball = GetBlogTitle(20201205, $bChinese);
	$strNasdaq100 = GetBlogTitle(20200915, $bChinese);
	$strFuturesPremium = GetBlogTitle(20200424, $bChinese);
	$strWechat = GetBlogTitle(20161014, $bChinese);
	$strSZ162411 = GetBlogTitle(20150818, $bChinese);
	$strMia = GetBlogTitle(20141204, $bChinese);
	$strStock = GetBlogTitle(20141016, $bChinese);
	$strGoogle = GetBlogTitle(20110509, $bChinese);
	$strPHP = GetBlogTitle(20100905, $bChinese);
	$strPalmmicro = GetBlogTitle(20080326, $bChinese);
	
	$strCategory = GetBlogMenuLinks($bChinese);
	$strYears = GetBlogYearLinks();
	$arYears = GetBlogYearTags();
	
    echo <<<END
<p>Category: $strCategory</p>
<p>Year: $strYears</p>
<p>All:
{$arYears[2023]} 
<br />$strUsdInterest
{$arYears[2020]} 
<br />$strSnowball
<br />$strNasdaq100
<br />$strFuturesPremium
{$arYears[2016]} 
<br />$strWechat
<br />Jun 15 EastMoney <a href="blog/entertainment/20160615.php">USDCNY Reference Rate</a> Data Interface
{$arYears[2015]} 
<br />Dec 25 The Interpretation of <a href="blog/entertainment/20151225.php">Sina Stock Data</a> Interface
<br />$strSZ162411
{$arYears[2014]} 
<br />$strMia
<br />$strStock
<br />Jun 15 Upgrade to <a href="blog/entertainment/20140615.php">Visual Studio</a> 2013
<br />Apr 5 <a href="blog/pa1688/20140405.php">The Good, the Bad and the Ugly</a>
{$arYears[2013]} 
<br />Aug 31 <a href="blog/pa3288/20130831.php">USB</a>
<br />Feb 10 <a href="blog/pa1688/20130210.php">Redial Key as Mute Key</a>
{$arYears[2012]} 
<br />Nov 11 <a href="blog/ar1688/20121111.php">Logic Puzzle: Find the Differences ...</a>
<br />Aug 11 Eroda Z1 <a href="blog/entertainment/20120811.php">GPS</a>
<br />Jul 19 My First Embedded <a href="blog/entertainment/20120719.php">Linux</a> Application
<br />Apr 30 <a href="blog/ar1688/20120430.php">Sending PTT via RFC 2833</a>
<br />Mar 29 <a href="blog/entertainment/20120329.php">Expo Professionals</a>
<br />Feb 13 <a href="blog/ar1688/20120213.php">AR168M VoIP Module without UART Functions</a>
<br />Feb 10 <a href="blog/pa1688/20120210.php">Email Records: the Death of an AudioPlus VOIP616 IP Phone</a>
{$arYears[2011]} 
<br />Dec 5 <a href="blog/ar1688/20111205.php">AR168M VoIP Module Function Test</a>
<br />Nov 20 <a href="blog/pa6488/20111120.php">From PA1688 to PA6488 - Ethernet PHY Ready?</a>
<br />Nov 13 <a href="blog/pa1688/20111113.php">The End of IAX2</a>
<br />Nov 4 <a href="blog/pa1688/20111104.php">Steps to Upgrade an Old PA168F</a>
<br />Oct 7 <a href="blog/ar1688/20111007.php">Stupid is as Stupid Does</a>
<br />Aug 26 <a href="blog/ar1688/20110826.php">Are You Stupid or Something?</a>
<br />Aug 14 <a href="blog/pa1688/20110814.php">The Logical Steps to Rescue a PA168Q</a>
<br />Jun 8 <a href="blog/entertainment/20110608.php">WiFi</a> Ethernet Bridge
<br />May 24 <a href="blog/pa6488/20110524.php">H.263 Compatibility</a>
<br />May 16 <a href="blog/pa6488/20110516.php">JPEG Story</a>
<br />$strGoogle
<br />Apr 27 <a href="blog/pa1688/20110427.php">Software Over-Optimization</a>
<br />Apr 20 <a href="blog/pa1688/20110420.php">My God the LM386 in AT323 Phone is Working ALL the Time!</a>
<br />Apr 11 <a href="blog/pa6488/20110411.php">From PA1688 to PA6488 - UART Function in Product Evolution</a>
<br />Apr 3 <a href="blog/ar1688/20110403.php">Disable STUN with Asterisk</a>
<br />Mar 31 <a href="blog/ar1688/20110331.php">AR1688 Programming Lesson 101</a>
<br />Mar 23 <a href="blog/entertainment/20110323.php">VoIP</a> Loser's Songs
<br />Mar 7 <a href="blog/ar1688/20110307.php">Interactive Voice Response</a>
<br />Feb 25 <a href="blog/pa1688/20110225.php">PA1688 Device Killer</a>
{$arYears[2010]} 
<br />Dec 25 <a href="blog/pa6488/20101225.php">EFSL File System</a>
<br />Dec 13 <a href="blog/pa6488/20101213.php">From PA1688 to PA6488 - G.729 Test Vectors</a>
<br />Dec 2 <a href="blog/ar1688/20101202.php">Writing Program Flash</a>
<br />Nov 23 <a href="blog/ar1688/20101123.php">The Journey to SDCC 3.0.0</a>
<br />Nov 7 Moving Blog - GB18030 and <a href="blog/entertainment/20101107.php">GB2312</a>
<br />Sep 9 <a href="blog/palmmicro/20100909.php">Forgot Password?</a>
<br />Sep 7 <a href="blog/pa1688/20100907.php">A Hard Day's Night</a>
<br />$strPHP
<br />Aug 18 <a href="blog/ar1688/20100818.php">AR1688 Windows Tools Compiled with VC2008</a>
<br />Jul 26 <a href="blog/entertainment/20100726.php">Raw Video Viewers</a>
<br />Jun 25 <a href="blog/ar1688/20100625.php">Out of Stock</a>
<br />Jun 6 <a href="blog/pa1688/20100606.php">False Alarm</a>
<br />May 29 My First <a href="blog/entertainment/20100529.php">Visual C++</a> 2008 Application
<br />Apr 27 <a href="blog/palmmicro/20100427.php">The Blocking History of Palmmicro.com</a>
<br />Feb 11 <a href="blog/pa6488/20100211.php">From PA1688 to PA6488 - Software API License Terms</a>
<br />Jan 9 <a href="blog/pa6488/20100109.php">From PA1688 to PA6488 - Web Interface</a>
{$arYears[2009]} 
<br />Dec 15 <a href="blog/pa1688/20091215.php">Mistakes I Made on Last Sunday</a>
<br />Nov 14 <a href="blog/palmmicro/20091114.php">Palmmicro MAC Address</a>
<br />Sep 27 <a href="blog/pa6488/20090927.php">From PA1688 to PA6488 - Safe Mode Recovery</a>
<br />Sep 1 <a href="blog/pa6488/20090901.php">From PA1688 to PA6488 - TFTP Performance</a>
<br />Aug 25 <a href="blog/pa6488/20090825.php">From PA1688 to PA6488 - Upgrade Software Size</a>
<br />Aug 19 <a href="blog/pa6488/20090819.php">PA648C Video Compression Module</a>
<br />Aug 16 <a href="blog/pa6488/20090816.php">From PA1688 to PA6488 - Upgrade Software Name</a>
<br />Aug 11 <a href="blog/pa6488/20090811.php">From PA1688 to PA6488 - Software Working Directory</a>
<br />Aug 8 <a href="blog/pa6488/20090808.php">From PA1688 to PA6488 - Ping Response Time</a>
<br />Apr 16 <a href="blog/ar1688/20090416.php">Voice Activity Detection</a>
<br />Mar 29 <a href="blog/ar1688/20090329.php">Small Device C Compiler 2.9.0</a>
<br />Mar 20 <a href="blog/ar1688/20090320.php">Pound Key as Call Key</a>
<br />Feb 19 From Palmmicro to <a href="blog/entertainment/20090219.php">CSR</a> in Ten Years
<br />Feb 17 <a href="blog/ar1688/20090217.php">Low Cost Phone</a>
{$arYears[2008]} 
<br />Dec 2 <a href="blog/ar1688/20081202.php">AR1688 Z80 Performance</a>
<br />Nov 24 <a href="blog/ar1688/20081124.php">Micrel KSZ8842</a>
<br />Sep 3 <a href="blog/ar1688/20080903.php">GPIO Control</a>
<br />Aug 11 <a href="blog/ar1688/20080811.php">Standard First</a>
<br />Aug 6 <a href="blog/pa1688/20080806.php">Non-Standard PA1688 Based Devices</a>
<br />Jul 29 <a href="blog/ar1688/20080729.php">Router, PPPoE and DM9003</a>
<br />Jul 16 <a href="blog/ar1688/20080716.php">Default Settings</a>
<br />Jul 8 <a href="blog/ar1688/20080708.php">AR168M VoIP Module Example</a>
<br />Jul 6 <a href="blog/ar1688/20080706.php">AR1688 Z80 Memory Map</a>
<br />Jun 24 <a href="blog/ar1688/20080624.php">Safe Mode Upgrade</a>
<br />Jun 15 <a href="blog/ar1688/20080615.php">A Farewell to RTL8019AS</a>
<br />Jun 7 <a href="blog/ar1688/20080607.php">Name Rules</a>
<br />May 12 <a href="blog/ar1688/20080512.php">Short Message Display</a>
<br />Mar 30 <a href="blog/ar1688/20080330.php">8051 Software Details</a>
<br />Mar 29 <a href="blog/ar1688/20080329.php">AR168M VoIP Module High Level UI Protocols</a>
<br />$strPalmmicro
<br />Feb 25 <a href="blog/ar1688/20080225.php">AR168M VoIP Module</a>
<br />Feb 22 <a href="blog/ar1688/20080222.php">Detail Steps to Add ISO 8859-2 Font to AR1688 Software</a>
<br />Feb 16 <a href="blog/ar1688/20080216.php">Font Resources</a>
<br />Jan 21 <a href="blog/ar1688/20080121.php">Z80 Speed</a>
<br />Jan 20 <a href="blog/ar1688/20080120.php">Do NOT Upgrade "Long" Ring Tone</a>
{$arYears[2007]} 
<br />Nov 27 <a href="blog/ar1688/20071127.php">Another Chip Select Signal</a>
<br />Nov 19 <a href="blog/ar1688/20071119.php">Simple UART</a>
<br />Nov 16 <a href="blog/ar1688/20071116.php">RTP First</a>
<br />Nov 14 <a href="blog/ar1688/20071114.php">Frames per TX</a>
<br />Nov 10 <a href="blog/ar1688/20071110.php">Speex Bandwidth Usage with IAX2 Protocol</a>
<br />Oct 31 <a href="blog/ar1688/20071031.php">Speex Actual Bandwidth Calculation</a>
<br />Aug 27 <a href="blog/ar1688/20070827.php">How to Change MAC Address</a>
<br />Aug 13 Around the World in 50 Days Paid by <a href="blog/entertainment/20070813.php">SiRF</a>
<br />Jul 4 <a href="blog/ar1688/20070704.php">Debug FAQ</a>
<br />Jun 9 <a href="blog/ar1688/20070609.php">How to Compile AR1688 API with Linux</a>
<br />Jun 7 <a href="blog/pa1688/20070607.php">Too Late Good News</a>
<br />Jun 5 <a href="blog/ar1688/20070605.php">How to Upgrade Font</a>
<br />Jun 4 <a href="blog/ar1688/20070604.php">Font in 2x16 Character LCD</a>
<br />Jun 3 <a href="blog/ar1688/20070603.php">ISO 8859 Font</a>
<br />Apr 5 <a href="blog/ar1688/20070405.php">Regional and Language Options</a>
<br />Mar 28 <a href="blog/ar1688/20070328.php">Ring Tone and Hold Music</a>
<br />Mar 21 <a href="blog/ar1688/20070321.php">Digit Maps</a>
<br />Mar 7 <a href="blog/ar1688/20070307.php">iLBC Codec Ready</a>
<br />Feb 16 <a href="blog/ar1688/20070216.php">Why Support ADPCM G.726 32k Codec</a>
{$arYears[2006]} 
<br />Dec 14 <a href="blog/ar1688/20061214.php">AR168F IP Phone Software Features</a>
<br />Dec 13 <a href="blog/ar1688/20061213.php">AR168F IP Phone Hardware Features</a>
<br />Dec 12 <a href="blog/ar1688/20061212.php">Chip Features</a>
<br />Dec 11 <a href="blog/ar1688/20061211.php">Software API Contents</a>
<br />Nov 23 <a href="blog/palmmicro/20061123.php">The Untold Story of Jan, Sing and Wang (Translation)</a>
<br />Oct 14 <a href="blog/ar1688/20061014.php">Chip Name and Board Name</a>
<br />Sep 30 <a href="blog/ar1688/20060930.php">Firmware Upgrade Size</a>
<br />Sep 29 <a href="blog/ar1688/20060929.php">Firmware Upgrade</a>
<br />Sep 28 <a href="blog/ar1688/20060928.php">What is AR1688</a>
</p>
END;
}

require('../php/ui/_disp.php');
?>
