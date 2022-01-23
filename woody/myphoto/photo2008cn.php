<?php
require('php/_myphoto.php');

function GetMetaDescription()
{
	return 'Woody的2008年个人图片和相关链接. 开始用车轮丈量美国, 用脚步丈量京郊. 图片来自于穷游网和北京绿野航天东风队的摄影爱好者们.';
}

function EchoAll()
{
    echo <<<END
<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>5月19日</a>, 加油. Vincent拍摄 <a href="2008/pumping.jpg" target=_blank>放大</a>
<br /><img src=2008/pumping_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>5月20日</a>, 思考. Vincent拍摄 <a href="2008/thinking.jpg" target=_blank>放大</a>
<br /><img src=2008/thinking_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>5月21日</a>, Crater Lake. 小英罗拍摄 <a href="2008/craterlake.jpg" target=_blank>放大</a>
<br /><img src=2008/craterlake_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>5月21日</a>, 无题. 奖励品拍摄 <a href="2008/nude.jpg" target=_blank>放大</a>
<br /><img src=2008/nude_s.jpg alt="Half nude Woody on the rim of Crater Lake" /></p>

<!--<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=112203" target=_blank>5月22日</a>, 海边. Vincent拍摄 <a href="2008/sea.jpg" target=_blank>放大</a>
<br /><img src=2008/sea_s.jpg></p>-->

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43360066" target=_blank>7月26日</a>, 百花山. <a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43363123" target=_blank>照片</a>
<br /><img src=2008/baihuashan.jpg alt="Woody on Bai Hua Shan in 2008" /></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43447742" target=_blank>10月26日</a>, 远离鞋子. 
<br /><img src=2008/shoes.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43452937" target=_blank>11月1日</a>, 谁知盘中餐, 粒粒皆辛苦. <a href="2008/eat.jpg" target=_blank>放大</a>
<br /><img src=2008/eat_s.jpg alt="Dinner after a half day walk in Beijing Olympic Park" /></p>

<!--<p>11月1日, 近照. <a href="2008/head.jpg" target=_blank>放大</a>
<br /><img src=2008/head_s.jpg alt="Dinner at a restaurant near Beijing Olympic Park" /></p>-->
END;
}

require('/php/ui/_dispcn.php');
?>
