<?php
require('php/_myphoto.php');

function GetMetaDescription()
{
	return 'Woody的2015年个人图片和相关链接. 包括马尔代夫Vilamendhoo岛, 和长沙火宫殿等. 从今年开始的相片中都带着女儿林近岚了, 看到哪一年她会开始拒绝吧.';
}

function EchoAll()
{
    echo <<<END
<p>4月1日. 唐宫海鲜舫, 每天都在忙着吃饭. <a href="2015/large/tanggong.jpg" target=_blank>放大</a>
<br /><img src=2015/tanggong.jpg alt="Sapphire in Tang Gong seafood restaurant." /></p>

<p>4月26日. 毛主席说: 火宫殿的臭豆腐, 闻起来臭, 吃起来香. <a href="../sapphire/2015/large/20150426.jpg" target=_blank>放大</a>
<br /><img src=../sapphire/2015/20150426.jpg alt="Sapphire Lin's first trip to Changsha." />
<br /><img src=1973/100days_s.jpg alt="Woody's 100 days photo." /></p>

<p>6月1日. 麦兜说: 马尔代夫, 蓝天白云, 椰林树影, 水清沙幼, 是坐落于印度洋上的世外桃源. <a href="../sapphire/2015/large/20150601.jpg" target=_blank>放大</a>
<br /><img src=../sapphire/2015/20150601.jpg alt="Sapphire Lin's trip to Vilamendhoo, Maldives." /></p>

<p>10月6日. 小妞第一次到北京. <a href="2015/large/beijing.jpg" target=_blank>放大</a>
<br /><img src=2015/beijing.jpg alt="Sapphire's first trip to Beijing." /></p>

<p>11月30日. 趁小妞的两个单眼皮彻底消失前抓紧合影一个. <a href="2015/large/home.jpg" target=_blank>放大</a>
<br /><img src=2015/home.jpg alt="Sapphire's double eyelid disappeared today." /></p>

END;
}

require('../../php/ui/_dispcn.php');
?>
