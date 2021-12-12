<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>WiFi Ethernet Bridge</title>
<meta name="description" content="How to connect PA648C to WiFi using the WDS function of a wireless router. WiFi Ethernet bridge WDS settings of TP-LINK TL-WR740N.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>WiFi Ethernet Bridge</h1>
<p>June 8, 2011
<br />One of the most frequently asked questions about <a href="../pa6488/20090819.php">PA648C</a> video over IP module is how to connect it to a WiFi network.
Since PA648C only have an Ethernet interface, what we need is a WiFi Ethernet bridge. It is easy and cheap.
<br />We can get a TP-LINK TL-WR740N wireless router in Chinese retail market for about 100RMB (about 15.4USD) now. It has built-in WDS function and can be configured to use as WiFi Ethernet bridge in the following way:
</p>
<ol>
  <li>Enable WDS function.</li>
  <li>Set up SSID(to be bridged) and BSSID(to be bridged) the AP of the WiFi network you are going to work with, the "Search" button can be used to search for those value, especially the BSSID.</li>
  <li>Set up the rest of WiFi options exactly as the AP, including channel, mode and security. Actually you need to set up the same security parameters twice,
      in both the "Wireless Settings"->"WDS" section and the "Wireless Security" section.</li>
  <li>Test and verify the bridge function is working.</li>
  <li>Disable DHCP server function on this bridge and set its local IP address to an address outside of the original DHCP server range.
      For example, set your original DHCP client address from 192.168.1.100 to 192.168.1.199 and set this bridge to 192.168.1.99. In this way, any device connected on this bridge will still use the original DHCP server.</li>
</ol>
<p>What if you have another wireless router in hand but it does not have function like "WDS"? <a href="https://openwrt.org/" target=_blank>OpenWrt</a> is where you should check,
it has open source software for a lot of routers, including function to turn a wireless router to a WiFi Ethernet bridge.
<br /><img src=../photo/20110608.jpg alt="WiFi Ethernet bridge WDS settings screenshot" />
<br /><img src=../photo/20111127.jpg alt="PA6488 and X-Lite fish demo via WiFi Ethernet bridge" />
<br /><img src=../photo/20110606.jpg alt="PA6488 and X-Lite fish demo screenshot" />
</p>
</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
