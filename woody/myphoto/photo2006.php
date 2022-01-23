<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2007 personal photos and related links. Starting Beijing suburb trips with lvye.org, from now on I have photographers!';
}

function EchoAll($bChinese)
{
    echo <<<END
<!--<p>Apr 2. Flowers outside Beijing city. <a href="2006/flower.jpg" target=_blank>Large</a>
<br /><img src=2006/flower_s.jpg></p>-->

<p>Apr 2. Sword hero dream. <a href="2006/sword.jpg" target=_blank>Large</a>
<br /><img src=2006/sword_s.jpg></p>

<p>Apr 30. Lost in translation. <a href="2006/lost.jpg" target=_blank>Large</a>
<br /><img src=2006/lost_s.jpg></p>

<!--<p>May 27. Beijing country park pass photo. <a href="2006/nianpiao.jpg" target=_blank>Large</a>
<br /><img src=2006/nianpiao_s.jpg></p>-->

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1528559" target=_blank>June 10</a>. Dangerous Miaofeng Mountain. <a href="2006/miaofengshan.jpg" target=_blank>Large</a>
<br /><img src=2006/miaofengshan_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1537444" target=_blank>June 25</a>. Longmen Valley. Photo taken by BianDou <a href="2006/longmenjian.jpg" target=_blank>Large</a>
<br /><img src=2006/longmenjian_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1545134" target=_blank>July 1</a>, I always feel lost on this Baihua Mountain. 
<br /><img src=2006/baihuashan.jpg alt="Woody on Bai Hua Shan in 2006" /></p>
END;
}

require('/php/ui/_disp.php');
?>
