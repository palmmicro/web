<?php
require('php/_myphoto.php');

function EchoAll($bChinese)
{
    echo <<<END
<p>Apr 1. Tang Gong seafood restaurant. <a href="2015/large/tanggong.jpg" target=_blank>Large</a>
<br /><img src=2015/tanggong.jpg alt="Sapphire in Tang Gong seafood restaurant." /></p>

<p>Apr 26. Sapphire's first trip to Changsha. <a href="../mia/2015/large/20150426.jpg" target=_blank>Large</a>
<br /><img src=../mia/2015/20150426.jpg alt="Sapphire Lin's first trip to Changsha." />
<br /><img src=1973/100days_s.jpg alt="Woody's 100 days photo." /></p>

<p>Jun 1. Sapphire's trip to Vilamendhoo, Maldives. <a href="../mia/2015/large/20150601.jpg" target=_blank>Large</a>
<br /><img src=../mia/2015/20150601.jpg alt="Sapphire Lin's trip to Vilamendhoo, Maldives." /></p>

<p>Oct 6. Sapphire's first trip to Beijing. <a href="2015/large/beijing.jpg" target=_blank>Large</a>
<br /><img src=2015/beijing.jpg alt="Sapphire's first trip to Beijing." /></p>

<p>Nov 30. Sapphire's double eyelid disappeared today. <a href="2015/large/home.jpg" target=_blank>Large</a>
<br /><img src=2015/home.jpg alt="Sapphire's double eyelid disappeared today." /></p>
END;
}

require('../../php/ui/_disp.php');
?>
