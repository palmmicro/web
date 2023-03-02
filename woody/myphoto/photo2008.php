<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2008 personal photos and related links. Begin travelling in United States by car and travelling in Beijing suburb by foot.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>May 19</a>. An exhausted man with his old car. Photo taken by Vincent <a href="2008/pumping.jpg" target=_blank>Large</a>
<br /><img src=2008/pumping_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>May 20</a>. Thinking. Photo taken by Vincent <a href="2008/thinking.jpg" target=_blank>Large</a>
<br /><img src=2008/thinking_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>May 21</a>. Crater Lake.  Photo taken by XiaoYingLuo <a href="2008/craterlake.jpg" target=_blank>Large</a>
<br /><img src=2008/craterlake_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>May 21</a>. The truman show.  Photo taken by JiangLiPin <a href="2008/nude.jpg" target=_blank>Large</a>
<br /><img src=2008/nude_s.jpg alt="Half nude Woody on the rim of Crater Lake" /></p>

<!--<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>May 22</a>. Sea. Photo taken by Vincent <a href="2008/sea.jpg" target=_blank>Large</a>
<br /><img src=2008/sea_s.jpg></p>-->

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43360066" target=_blank>July 26</a>. The persuit of happyness. <a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43363123" target=_blank>Photo</a>
<br /><img src=2008/baihuashan.jpg alt="Woody on Bai Hua Shan in 2008" /></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43447742" target=_blank>Oct 26</a>. Away from her shoes.
<br /><img src=2008/shoes.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43452937" target=_blank>Nov 1</a>. Eat. <a href="2008/eat.jpg" target=_blank>Large</a>
<br /><img src=2008/eat_s.jpg alt="Dinner after a half day walk in Beijing Olympic Park" /></p>

<!--<p>Nov 1. Head. <a href="2008/head.jpg" target=_blank>Large</a>
<br /><img src=2008/head_s.jpg alt="Dinner at a restaurant near Beijing Olympic Park" /></p>-->
END;
}

require('../../php/ui/_disp.php');
?>
