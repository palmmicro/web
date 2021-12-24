<?php
require('php/_myphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2014年个人图片和相关链接. 包括小雪拍的深圳二四莲1000期活动时在梅林后山晒太阳乐不可支的照片, 和闺女林近岚出生后在医院测试长时间闲置相机的结果.';
}

function EchoAll()
{
    echo <<<END
<p><a href="http://www.doyouhike.net/forum/leisure/1013822,0,0,1.html" target=_blank>1月11日</a>. 梅林后山的阳光. 小雪拍摄 <a href="2014/large/sunshine.jpg" target=_blank>放大</a>
<br /><img src=2014/sunshine.jpg alt="Sunshine on my shoulders in Mei Lin" /></p>

<p>11月16日. 闺女出生后在医院测试长时间闲置的相机. <a href="2014/large/hospital.jpg" target=_blank>放大</a>
<br /><img src=2014/hospital.jpg alt="In the hospital where Sapphire was born" /></p>

<p>11月21日. <a href="../blog/entertainment/20141204cn.php">林近岚</a>的由来. <a href="https://ci-baby.taobao.com" target=_blank>小西</a>拍摄 <a href="../blog/photo/large/20141204.jpg" target=_blank>放大</a>
<br /><img src=../blog/photo/20141204.jpg alt="Woody and Sapphire Lin are both worried!" /></p>

<p>12月13日. <a href="../sapphire/photo30dayscn.php">满月艺术照</a>, 跟沾光的爸爸合影. <a href="../sapphire/30days/large/dad10.jpg" target=_blank>放大</a>
<br /><img src=../sapphire/30days/dad10.jpg alt="Sapphire Lin in red hat and red dot dress with Woody." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
