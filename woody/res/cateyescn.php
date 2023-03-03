<?php
require('php/_res.php');

function GetTitle()
{
	return '西雅图夜猫眼';
}

function GetMetaDescription()
{
	return '淘宝店西雅图夜猫眼的介绍以及部分商品和模特展示. 商品包括3.89克拉亚历山大变色金绿猫眼和5.94克拉祖母绿猫眼. 模特有一只苏格兰折耳母猫包子和一只英国短毛公猫多多.';
}

function EchoAll()
{
    echo <<<END
<p>淘宝<a href="http://shop58325285.taobao.com/" target=_blank>链接</a></p>

<p>天然<a href="cateyes/alexandrite389cn.php">3.89克拉亚历山大</a>变色金绿猫眼
<br /><img src=cateyes/alexandrite/389/naturelight.jpg alt="alexandrite cat eye 3.89ct in nature light" /></p>

<p>天然无油<a href="cateyes/emerald594cn.php">5.94克拉祖母绿</a>猫眼
<br /><img src=cateyes/emerald/594/ring.jpg alt="emerald cat eye 5.94ct on ring" /></p>

<p>模特<a href="cateyes/baozicn.php">包子</a>
<br /><img src=cateyes/models/baozi/emerald.jpg alt="Scottish fold female cat with emerald" /></p>

<p>模特<a href="cateyes/baozicn.php">包子</a>和多多 <a href="cateyes/models/baozi/large/srilanka.jpg" target=_blank>大图</a>
<br /><img src=cateyes/models/baozi/srilanka.jpg alt="Scottish fold female cat and British shorthair male cat in front of a Sri Lanka jewelry map" /></p>

<p>2012年7月29日店主和我在马来西亚吉隆坡. CT Khoo拍摄 <a href="../groupphoto/world/large/KualaLumpur.jpg" target=_blank>大图</a>
<br /><img src=../groupphoto/world/KualaLumpur.jpg alt="Lobster meal at a Chinese restaurant in Kuala Lumpur." /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
