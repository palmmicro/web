<?php
require('php/_sapphire.php');

function EchoMetaDescription($bChinese)
{
	echo 'Sapphire 2016 personal photos and related links. Although I spent a lot of time on it, I guess Sapphire might hate those in the future.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>June 24. Beautiful girl made in Korea. <a href="2016/large/20160624.jpg" target=_blank>Large</a>
<br /><img src=2016/20160624.jpg alt="Sapphire in NAMU Plastic Surgery & Dermatology." /></p>

<p>June 7. First free will at the wheel. <a href="2016/large/20160607.jpg" target=_blank>Large</a>
<br /><img src=2016/20160607.jpg alt="Saphhire's first free will at the wheel." /></p>

<p>May 29. Bookstore is my favorite. <a href="2016/large/20160529.jpg" target=_blank>Large</a>
<br /><img src=2016/20160529.jpg alt="Bookstore is Sapphire's favorite." /></p>

<p>March 18. Real estate developer says this is Maldives in China. <a href="2016/large/20160318.jpg" target=_blank>Large</a>
<br /><img src=2016/20160318.jpg alt="Sapphire on the beach of Maldives in China." /></p>

<p>Feb 16. Playing in supermarket. <a href="2016/large/20160216.jpg" target=_blank>Large</a>
<br /><img src=2016/20160216.jpg alt="Sapphire playing in supermarket." /></p>

<p>Feb 9. Eating spicy spaghetti by herself. <a href="2016/large/20160209.jpg" target=_blank>Large</a>
<br /><img src=2016/20160209.jpg alt="Sapphire eating spicy spaghetti." /></p>

<p>Jan 25. Caught cold again. <a href="2016/large/20160125.jpg" target=_blank>Large</a>
<br /><img src=2016/20160125.jpg alt="Sapphire caught cold again." /></p>

<p>Jan 15. On Shenzhen subway. <a href="2016/large/20160115.jpg" target=_blank>Large</a>
<br /><img src=2016/20160115.jpg alt="Sapphire on Shenzhen subway." /></p>
END;
}

require('/php/ui/_disp.php');
?>
