<?php
require_once('php/_mia.php');

function EchoAll()
{
	$strMia30Days = GetMia30DaysLink();
	
    echo <<<END
<p>12月26日. 全副武装出门. 去妇幼保健院再做一次42天体检, 10斤, 56厘米. <a href="large/20141226.jpg" target=_blank>放大</a>
<br /><img src=2014/20141226.jpg alt="Sapphire Lin going out." /></p>

<p>12月21日. 直接在大水桶里大小便! 拉之前体检9斤半, 55厘米高, 胸围36.5厘米, 头围37.5厘米. <a href="large/20141221.jpg" target=_blank>放大</a>
<br /><img src=2014/20141221.jpg alt="Sapphire Lin swimming." /></p>

<p>12月14日. 发现后脑勺上有个胎记. <a href="large/20141214.jpg" target=_blank>放大</a>
<br /><img src=2014/20141214.jpg alt="Sapphire Lin's birthmark on the head." /></p>

<p>12月13日. 今天我{$strMia30Days}. <a href="large/20141213.jpg" target=_blank>放大</a>
<br /><img src=2014/20141213.jpg alt="Sapphire Lin on Dec 13, 2014." />
<br /><img src=2014/20141213_2.jpg alt="Sapphire Lin is one month now." /></p>

<p>12月3日. 再次咪出双眼皮. <a href="large/20141203.jpg" target=_blank>放大</a>
<br /><img src=2014/20141203.jpg alt="Sapphire Lin on Dec 3, 2014." /></p>

<p>11月30日. 谁说我是单眼皮. <a href="large/20141130.jpg" target=_blank>放大</a>
<br /><img src=2014/20141130.jpg alt="Sapphire Lin on Nov 30, 2014." /></p>

<p>11月29日. 展示尿迹的连环腿. <a href="large/20141129.jpg" target=_blank>放大</a>
<br /><img src=2014/20141129.jpg alt="Legs of Sapphire Lin." /></p>

<p>11月28日. 毛茸茸的耳朵. <a href="large/20141128.jpg" target=_blank>放大</a>
<br /><img src=2014/20141128.jpg alt="Hairy ear of Sapphire Lin." /></p>

<p>11月26日. 胖乎乎的手. <a href="large/20141126.jpg" target=_blank>放大</a>
<br /><img src=2014/20141126.jpg alt="Fat hand of Sapphire Lin." /></p>

<p>11月22日. 难得睁开双眼. <a href="large/20141122.jpg" target=_blank>放大</a>
<br /><img src=2014/20141122.jpg alt="Sapphire Lin with open eyes" />
<br /><img src=2014/20141122_2.jpg alt="Sapphire Lin opens her eyes and put her tongue out." /></p>

<p>11月21日. 变黄了. <a href="large/20141121.jpg" target=_blank>放大</a>
<br /><img src=2014/20141121.jpg alt="Sapphire Lin turning yellow" /></p>

<p>11月19日. 换个新环境继续睡. <a href="large/20141119.jpg" target=_blank>放大</a>
<br /><img src=2014/20141119.jpg alt="Sapphire Lin continuing to sleep in a new environment" /></p>

<p>11月18日. 换妈妈的床睡. <a href="large/20141118.jpg" target=_blank>放大</a>
<br /><img src=2014/20141118.jpg alt="Sapphire Lin sleeping in mother's bed" /></p>

<p>11月17日. 洗澡. <a href="large/20141117.jpg" target=_blank>放大</a>
<br /><img src=2014/20141117.jpg alt="Sapphire Lin taking a bath" /></p>

<p>11月14日. 努力想睁开一只眼. <a href="large/20141114.jpg" target=_blank>放大</a>
<br /><img src=2014/20141114.jpg alt="Sapphire Lin trying to open an eye" /></p>

<p>11月13日. 7斤整闺女. 身长50厘米. 头围35厘米, 胸围32厘米. 分娩时间早上8点55分. <a href="large/20141113.jpg" target=_blank>放大</a>
<br /><img src=2014/20141113.jpg alt="Sapphire Lin is born" /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
