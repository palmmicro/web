<?php
require('php/_editinput.php');

function EchoRelated()
{
	$strTaobao = GetTaobaoDouble11Data();
	$strTaobaoSales = GetTaobaoSalesData();
	$strBaba = GetMyStockLink('BABA');

	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li>淘宝天猫从2009年开始双11交易额(亿元): <font color=gray>$strTaobao</font></li>
	    <li>阿里{$strBaba}从2010年开始财报中的总销售额(亿元): <font color=gray>$strTaobaoSales</font></li>
    </ol>
END;
}

require('/php/ui/_dispcn.php');
?>
