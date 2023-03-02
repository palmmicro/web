<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2011 personal photos and related links. YiGong provided most of them during our Hongkong and Shenzhen trips this year.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Feb 27. I always wear a <a href="../blog/entertainment/20110323.php">VoIP</a> loser's tired smile in recent months. Photo taken by YiGong <a href="2011/wutong.jpg" target=_blank>Large</a>
<br /><img src=2011/wutong_s.jpg alt="tired smile on Shenzhen Wutong Mountain" /></p>

<!--<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43999114" target=_blank>March 6</a>. Jiu Long Mountain. <a href="../blog/entertainment/20110805.php">Can not figure out the way</a>. Photo taken by No.1 <a href="2011/jiulong.jpg" target=_blank>Large</a>
<br /><img src=2011/jiulong_s.jpg alt="Beijing Jiu Long Mountain" /></p>-->

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44020696" target=_blank>Apr 24</a>. Lao Xiang Peak. <a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44022538" target=_blank>Photo</a> taken by CunZhang <a href="2011/elephant.jpg" target=_blank>Large</a>
<br /><img src=2011/elephant_s.jpg alt="Lao Xiang Peak" /></p>

<!--<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44051785" target=_blank>July 3</a>. <a href="../blog/pa6488/20110715.php">Speech</a> on trip finance. Photo taken by XinYu <a href="2011/speech.jpg" target=_blank>Large</a>
<br /><img src=2011/speech_s.jpg alt="Beijing Yun Feng Mountain" /></p>-->

<p>July 17. Lantau Peak. Photo taken by YiGong <a href="2011/lantau.jpg" target=_blank>Large</a> Another climber who traveling alone shot the picture for <a href="../blog/photo/20110723.jpg" target=_blank>all of us</a>. <a href="../blog/photo/large/20110723.jpg" target=_blank>All Large</a>
<br /><img src=2011/lantau_s.jpg alt="Hongkong Lantau Peak" /></p>

<p>Sep 17. Under the foot of grandpa Deng. Photo taken by YiGong <a href="2011/lianhua.jpg" target=_blank>Large</a>
<br /><img src=2011/lianhua_s.jpg alt="Shenzhen Lian Hua Peak" /></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44119889" target=_blank>Oct 29</a>. Keep walking. Photo taken by KongLing <a href="2011/yanyu.jpg" target=_blank>Large</a>
<br /><img src=2011/yanyu_s.jpg alt="Beijing Yan Yu Peak" /></p>
END;
}

require('../../php/ui/_disp.php');
?>
