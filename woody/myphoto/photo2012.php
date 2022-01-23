<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2012 personal photos and related links. The year is the end of my Beijing suburb travelling with lvye.org and the Hang Tian Dong Feng team.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44158328" target=_blank>Apr 14</a>. While they were sleeping. <a href="2012/large/awake.jpg" target=_blank>Large</a>
<br /><img src=2012/awake.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44164336" target=_blank>May 12</a>. Jump. <a href="2012/large/jump.jpg" target=_blank>Large</a>
<br /><img src=2012/jump.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=44201356" target=_blank>Oct 27</a>. Goodbye Beijing. <a href="2012/large/goodbye.jpg" target=_blank>Large</a>
<br /><img src=2012/goodbye.jpg alt="a view of Woody's back on the ridge top of Baihua Mountain" /></p>
END;
}

require('/php/ui/_disp.php');
?>
