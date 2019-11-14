<?php
require('php/_editinput.php');

function EchoRelated()
{
	$strTaobao = GetTaobaoDouble11Data();

	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li>淘宝天猫从2009年开始双11交易额(亿元): <font color=gray>$strTaobao</font></li>
    </ol>
END;
}

require('/php/ui/_dispcn.php');
?>
