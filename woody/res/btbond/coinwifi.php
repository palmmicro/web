<?php
require('php/_btbond.php');

function EchoTitle($bChinese)
{
    echo 'Coin WiFi Hotspot';
}

function EchoMetaDescription($bChinese)
{
	echo 'Coin WiFi hotspot from Btbond Technology, Inc. Placed here in palmmicro web site by the request of its founder.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Product Features:</p>
<ol>
  <li>IEEE802.11n Wireless AP</li>
  <li>2T2R Antenna to ensure 300M high-throughput</li>
  <li>Large 64MB DDR to support 100+ simultaneous oline</li>
  <li>Build-in 58mm thermal printer for QR code print-out</li>
  <li>Direct connect to WAN port & internet. No 3rd party account servers</li>
</ol>

<p>View <a href="coinwifi/us/large/view.jpg" target=_blank>Large</a>
<br /><img src=coinwifi/us/view.jpg alt="English brochure of coin WiFi hotspot" /></p>

<p>Specification <a href="coinwifi/us/large/spec.jpg" target=_blank>Large</a>
<br /><img src=coinwifi/us/spec.jpg alt="English specification of coin WiFi hotspot" /></p>
END;
}

require('/php/ui/_disp.php');
?>
