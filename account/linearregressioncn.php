<?php
require('php/_editinput.php');

function EchoRelated()
{
	$strTaobao = GetTaobaoDouble11SqrtData();
	$strBenford = GetStandardBenfordData();

	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li><a href="../woody/res/sz162411cn.php">华宝油气</a>2019年8月16日到22日场内溢价百分比x和场内申购账户数y: <font color=gray>1.02,5069; 0.51,3081; 2.92,6936; 3.47,7846; 2.07,5583</font></li>
	    <li>淘宝天猫从x=0(2009年)开始双11交易额y(亿元): <font color=gray>$strTaobao</font></li>
	    <li>阿里美股历年x=0(2010年)财报中的总销售额y(亿元): <font color=gray>66.7; 119; 200; 345; 525; 762; 1011; 1583; 2503; 3768</font></li>
	    <li>本福特标准分布: <font color=gray>1,$strBenford</font></li>
    </ol>
END;
}

require('/php/ui/_dispcn.php');
?>
