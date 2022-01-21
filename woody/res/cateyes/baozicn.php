<?php
require('php/_cateyes.php');

function EchoTitle()
{
    echo '猫眼模特包子';
}

function EchoMetaDescription()
{
	echo '淘宝店西雅图夜猫眼的母苏格兰折耳猫模特包子. 包括戴祖母绿的照片和在北京拍的最不希望被人看到的洗澡照片. http://shop58325285.taobao.com/';
}

function EchoAll()
{
    echo <<<END
<p>生日: 2011年8月3日
<br />出生地: 北京
<br />性别: 母
<br />品种: 苏格兰折耳
</p>

<p>祖母绿 <a href="models/baozi/large/emerald.jpg" target=_blank>大图</a>
<br /><img src=models/baozi/emerald.jpg alt="Scottish fold female cat with emerald" /></p>

<p>北京包子最不希望被人看到的照片 <a href="../../blog/photo/large/20120420.jpg" target=_blank>大图</a>
<br /><img src=../../blog/photo/20120420.jpg alt="Scottish fold female cat taking a shower" /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
