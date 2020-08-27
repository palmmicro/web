<?php require_once('php/_pa3288.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>USB</title>
<meta name="description" content="After years of USB related study, Woody now finally has the opportunity to use it with Palmmicro PA3288 VoIP solution. Check our new WiFi VoIP product plan.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>USB</h1>
<p>Aug 31, 2013
Designed as a MP3 and digital camera chip, <a href="../../../pa1688/index.html">PA1688</a> has built in USB 1.1 device, but we had never used it in our VoIP software.
<br />In 2004 a new CEO replaced <a href="../palmmicro/20061123.php">Dr Wang</a> at Centrality.
After the new CEO's visit to Beijing at the end of the year, I knew it clearly that we had to go on VoIP business by ourselves at any time.
<br />I was very actively planning what to do next in 2005 and finally decided to develop an USB FXS gateway solution first, as an extra VoIP product for our existing customers.
And then a WiFi VoIP solution to replace PA1688 later.
<br />I signed a contract with a chip design company in China, paid NRE for the 8051+USB chip, and started learning USB software programming.
Soon I found Keil has provided complete USB examples we need, with USB HID, audio and mass storage class on its MCB2140 board with Philips LPC2148 chip.
<br />The USB FXS gateway product idea was good. MagicJack sold tens of millions of such products years later, earned enough money to take over the first VoIP company VocalTec in a reverse takeover on July 16, 2010.
But we did not finish our solution. 
<br />At the end of 2005 the CEO finally fired us. Although the layoff letter came a few months later than I expected,
the decision of discontinuing PA1688 shocked me. I had to give up the USB chip and find a new solution to replace PA1688 for our customers as soon as possible.
<br />As a quick replacement, we developed <a href="../../../ar1688/index.html">AR1688</a> solution based on a popular MP3 chip in 2006. It has built in USB 2.0 device,
but we had never used it in our VoIP software neither.
<br />Things are different with PA3288 now. With USB 2.0 OTG, it is almost the chip of my dream back in 2005.
We are planning to add WiFi USB dongle support to it and build a low cost WiFi <a href="../entertainment/20110323.php">VoIP</a> solution. As a first step, I found out the updated version of MCB2140 USBMem examples from Keil,
Tang Li put it together with open source <a href="../pa6488/20101225.php">EFSL</a> file system,
now PA328A board can work as a standard FAT16 <a href="../../../pa3288/software/devguide/usb.php">USB</a> storage class disk for debug purpose.
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

