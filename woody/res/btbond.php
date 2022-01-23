<?php
require('php/_res.php');

function GetTitle($bChinese)
{
	return 'Btbond Technology, Inc.';
}

function GetMetaDescription($bChinese)
{
	return 'Btbond Technology, Inc. introduction with some products display, placed here by the request of its founder.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Company <a href="http://www.btbond.com" target=_blank>web site</a>
<br />Room 425, Number 19-11 Sanchong Road, Taipei 11501, Taiwan
<br />Phone: (+886)02-2655-0220
<br />Email: sales@btbond.com
</p>

<p><a href="btbond/coinwifi.php">Coin WiFi Hotspot</a>
<br /><img src=btbond/coinwifi/us/view.jpg alt="English brochure of coin WiFi hotspot" />
</p>
END;
}

require('/php/ui/_disp.php');
?>
