<?php
require('php/_editinput.php');

function EchoRelated()
{
	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li>华宝油气2019年8月16日到22日场内溢价百分比x和场内申购账户数y: <font color=gray>1.02,5069; 0.51,3081; 2.92,6936; 3.47,7846; 2.07,5583</font></li>
	    <li>淘宝天猫从x=0(2009年)开始双11交易额y(亿元): <font color=gray>sqrt(0,0.5; 1,9.36; 2,52; 3,191; 4,352; 5,571; 6,912; 7,1207; 8,1682.69; 9,2135; 10,2684)</font></li>
    </ol>
END;
}

require('/php/ui/_dispcn.php');
?>
