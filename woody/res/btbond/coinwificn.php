<?php
require('php/_btbond.php');

function GetTitle()
{
	return 'Coin WiFi投币式上网分享器';
}

function GetMetaDescription()
{
	return '藍邦科技有限公司的Coin WiFi投币式上网分享器展示. 在公司的创始人要求下放在Palmmicro网站. 公司网站 http://www.btbond.com';
}

function EchoAll()
{
    echo <<<END
<p>产品功能:</p>
<ol>
  <li>IEEE802.11n Wireless AP</li>
  <li>2T2R 双天线设计可支持300Mbps高速无线传输</li>
  <li>专业级大容量64MB DDR内存, 100人可同时畅快上网</li>
  <li>内建58mm热敏打印机, 投币就列印上网QR Code/密码</li>
  <li>直连电信ADSL网络, 绝无第三方后台与恶意软件</li>
</ol>

<p>外观 <a href="coinwifi/cn/large/view.jpg" target=_blank>大图</a>
<br /><img src=coinwifi/cn/view.jpg alt="Chinese brochure of coin WiFi hotspot" /></p>

<p>指标 <a href="coinwifi/cn/large/spec.jpg" target=_blank>大图</a>
<br /><img src=coinwifi/cn/spec.jpg alt="Chinese specification of coin WiFi hotspot" /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
