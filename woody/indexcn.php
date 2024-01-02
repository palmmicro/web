<?php
require('php/_woody.php');
require_once('../php/stocklink.php');

function GetTitle()
{
	return 'Woody的资源共享';
}

function GetMetaDescription()
{
	return '跟本网站相关的开发和分析及赚钱的网络资源，家人和朋友们开的公司，自己开发的软件。包括Woody的Web Tool，华宝油气(sz162411)净值计算，IP地址查询等工具。';
}

function EchoAll()
{
	$strStock = GetStockCategoryLinks();
	$strAccount = GetAccountToolLinks();
	$strImage = ImgWoodyHomepage();
	$strMenu = GetWoodyMenuParagraph();
	
    echo <<<END
<p>我的股票软件
<br />$strStock
</p>

<p>我的工具软件
<br />$strAccount
</p>

<p>家人和朋友们开的公司
<br />受<a href="res/btbondcn.php">Btbond</a>创始人之托在这里展示它的产品。
<br />娃妈的<a href="res/cateyescn.php">西雅图夜猫眼</a>店，我未来的Borsheim珠宝店。 
</p>

<p>友情链接
<br /><a href="http://www.kancaibao.com" target=_blank>看财报</a>
<br /><a href="http://www.haoetf.com" target=_blank>HaoETF</a>
</p>

<p>$strImage
</p>
$strMenu
END;
}

require('../php/ui/_dispcn.php');
?>
