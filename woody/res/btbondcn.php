<?php
require('php/_res.php');

function GetTitle()
{
	return '藍邦科技有限公司';
}

function GetMetaDescription()
{
	return '藍邦科技有限公司的介绍以及部分商品展示例如Coin WiFi投币式上网分享器. 在公司的创始人要求下放在Palmmicro网站. 公司网站 http://www.btbond.com';
}

function EchoAll()
{
    echo <<<END
<p>公司<a href="http://www.btbond.com" target=_blank>网站</a>
<br />台北市南港區三重路19-11號E棟4樓
<br />台湾, ROC
<br />电话: (+886)02-2655-0220
<br />电子邮件: sales@btbond.com
</p>

<p><a href="btbond/coinwificn.php">Coin WiFi投币式上网分享器</a>
<br /><img src=btbond/coinwifi/cn/view.jpg alt="Chinese brochure of coin WiFi hotspot" />
</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
