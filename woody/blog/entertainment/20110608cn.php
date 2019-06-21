<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Ethernet转WiFi</title>
<meta name="description" content="PA6488开发中的副产品: 如何利用无线路由器中的WDS功能把PA648C接到WiFi网络上, 包括TP-LINK TL-WR740N的Ethernet转WiFi中WDS设置的截屏.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>Ethernet转WiFi</h1>
<p>2011年6月8日
<br />伴随<a href="../pa6488/20090819cn.php">PA648C</a>网络视频模块而来的最常见问题之一, 是如何把它接到一个WiFi网络上. 由于PA648C只有固定Ethernet接口, 我们需要一个既方便又便宜的Ethernet转WiFi的网桥. 
<br />今天在电子市场可以花100人民币买一个TP-LINK TL-WR740N无线路由器. 它内部有WDS功能, 可以按以下步骤设置成一个Ethernet转WiFi的网桥:
</p>
<ol>
  <li>开启WDS功能.</li>
  <li>把(桥接的)SSID和(桥接的)BSSID的值设置成你要加入工作的WiFi网络中AP的值. 用"扫描"键可以方便的找到这些值, 尤其是BSSID.</li>
  <li>把剩下的WiFi相关选项都设置成跟AP一致, 包括信道, 模式和加密等. 事实上你需要把同样的加密参数设置2次, 一次在"基本设置"->"WDS"选项下面, 另外一次在"无线安全设置"部分.</li>
  <li>测试确认网桥功能正常.</li>
  <li>关闭你的新网桥上的DHCP服务器, 并且把它的IP地址设置到一个老DHCP服务器不使用的地方. 例如, 设置你的老DHCP服务器使用从192.168.1.100到192.168.1.199用于分配地址, 把这个新网桥的地址设置成192.168.1.99.
      这样任何接到网桥上的设备都可以依旧使用原来的DHCP服务器.</li>
</ol>
<p>如果你手头能找到的无线路由器没有类似于"WDS"的功能, 那你应该去<a href="https://openwrt.org/" target=_blank>OpenWrt</a>看看. 上面有给各种路由器的开放源代码的软件, 其中包括把无线路由器改为Ethernet转WiFi网桥的功能. 
<br /><img src=../photo/20110608.jpg alt="WiFi Ethernet bridge WDS settings screenshot" />
<br /><img src=../photo/20111127.jpg alt="PA6488 and X-Lite fish demo via WiFi Ethernet bridge" />
<br /><img src=../photo/20110606.jpg alt="PA6488 and X-Lite fish demo screenshot" />
</p>
</div>

<?php _LayoutBottom(); ?>

</body>
</html>
