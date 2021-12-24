<?php
require('php/_myphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2007年个人图片和相关链接. 除了一个测试相机的大头照外, 几乎所有的记录都来自于跟绿野走京郊的活动.';
}

function EchoAll()
{
    echo <<<END
<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1869874" target=_blank>5月27日</a>, 房山蓦然回首. 
<br /><img src=2007/fangshan.jpg></p>

<p>6月2日, 十渡孤山寨. 景水拍摄 <a href="2007/shidu.jpg" target=_blank>放大</a>
<br /><img src=2007/shidu_s.jpg></p>

<p>7月27日, 北京中关村市场. <a href="2007/market.jpg" target=_blank>放大</a>
<br /><img src=2007/market_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43106311" target=_blank>10月27日</a>, 司马台长城上. <a href="2007/simatai.jpg" target=_blank>放大</a>
<br /><img src=2007/simatai_s.jpg alt="Woody sit on Beijing Simatai part of the Great Wall of China" /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
