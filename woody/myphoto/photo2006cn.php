<?php
require('php/_myphoto.php');

function EchoAll()
{
	$strLost = GetQuoteElement('Lost in translation');
	$strImg0701 = ImgWoody20060701();
	
    echo <<<END
<p>开始跟绿野走京郊, 突然之间有人给我拍照了.</p>  
<!--<p>4月2日, 北京郊外. <a href="2006/flower.jpg" target=_blank>放大</a>
<br /><img src=2006/flower_s.jpg></p>-->

<p>4月2日, 温柔一刀. <a href="2006/sword.jpg" target=_blank>放大</a> <font color=#545454>到京城来碰运气的人, 王小石是其中之一. 他年轻, 俊秀, 志大, 才高, 远道而来, 一贫如洗. 但他觉得金风细细, 烟雨迷迷, 眼前万里江山, 什么都阻不了他闯荡江湖的雄心壮志. <B><em>温瑞安</em></B></font>
<br /><img src=2006/sword_s.jpg></p>

<p>4月30日, 惘然若失. $strLost <a href="2006/lost.jpg" target=_blank>放大</a>
<br /><img src=2006/lost_s.jpg></p>

<!--<p>5月27日, 为郊区年票拍的照片. <a href="2006/nianpiao.jpg" target=_blank>放大</a>
<br /><img src=2006/nianpiao_s.jpg></p>-->

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1528559" target=_blank>6月10日</a>, 妙峰山遇险. <a href="2006/miaofengshan.jpg" target=_blank>放大</a>
<br /><img src=2006/miaofengshan_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1537444" target=_blank>6月25日</a>, 龙门涧. 扁豆拍摄 <a href="2006/longmenjian.jpg" target=_blank>放大</a>
<br /><img src=2006/longmenjian_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1545134" target=_blank>7月1日</a>, 每次上百花山我总是会迷路. 
$strImg0701
</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
