<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2007 personal photos and related links. All from Beijing suburb trips with lvye.org except one camera test shooting.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=1869874" target=_blank>May 27</a>. Looking for someone?
<br /><img src=2007/fangshan.jpg></p>

<p>June 2. ShiDu. Photo taken by Jingshui <a href="2007/shidu.jpg" target=_blank>Large</a>
<br /><img src=2007/shidu_s.jpg></p>

<p>July 27. Beijing market. <a href="2007/market.jpg" target=_blank>Large</a>
<br /><img src=2007/market_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43106311" target=_blank>Oct 27</a>. SiMaTai Great Wall. <a href="2007/simatai.jpg" target=_blank>Large</a>
<br /><img src=2007/simatai_s.jpg alt="Woody sit on Beijing Simatai part of the Great Wall of China" /></p>
END;
}

require('/php/ui/_disp.php');
?>
