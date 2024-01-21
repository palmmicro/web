<?php
require_once('php/_miatitle.php');

function GetMetaDescription($bChinese)
{
	return 'Sapphire 2014 personal photos and related links. Although I spent a lot of time on it, I guess Sapphire might hate those in the future.';
}

function EchoAll($bChinese)
{
	$strMia30Days = GetMia30DaysLink($bChinese);
	
    echo <<<END
<p>Dec 26. Going out. <a href="large/20141226.jpg" target=_blank>Large</a>
<br /><img src=2014/20141226.jpg alt="Sapphire Lin going out." /></p>

<p>Dec 21. Swimming. <a href="large/20141221.jpg" target=_blank>Large</a>
<br /><img src=2014/20141221.jpg alt="Sapphire Lin swimming." /></p>

<p>Dec 14. Birthmark on the head. <a href="large/20141214.jpg" target=_blank>Large</a>
<br /><img src=2014/20141214.jpg alt="Sapphire Lin's birthmark on the head." /></p>

<p>Dec 13. I'm $strMia30Days old today. <a href="large/20141213.jpg" target=_blank>Large</a>
<br /><img src=2014/20141213.jpg alt="Sapphire Lin on Dec 13, 2014." />
<br /><img src=2014/20141213_2.jpg alt="Sapphire Lin is one month now." /></p>

<p>Dec 3. Double eyelid again. <a href="large/20141203.jpg" target=_blank>Large</a>
<br /><img src=2014/20141203.jpg alt="Sapphire Lin on Dec 3, 2014." /></p>

<p>Nov 30. Double eyelid show. <a href="large/20141130.jpg" target=_blank>Large</a>
<br /><img src=2014/20141130.jpg alt="Sapphire Lin on Nov 30, 2014." /></p>

<p>Nov 29. Legs. <a href="large/20141129.jpg" target=_blank>Large</a>
<br /><img src=2014/20141129.jpg alt="Legs of Sapphire Lin." /></p>

<p>Nov 28. Hairy ear. <a href="large/20141128.jpg" target=_blank>Large</a>
<br /><img src=2014/20141128.jpg alt="Hairy ear of Sapphire Lin." /></p>

<p>Nov 26. Fat hand. <a href="large/20141126.jpg" target=_blank>Large</a>
<br /><img src=2014/20141126.jpg alt="Fat hand of Sapphire Lin." /></p>

<p>Nov 22. Not easy to take an open eyes photo. <a href="large/20141122.jpg" target=_blank>Large</a>
<br /><img src=2014/20141122.jpg alt="Sapphire Lin with open eyes" />
<br /><img src=2014/20141122_2.jpg alt="Sapphire Lin opens her eyes and put her tongue out." /></p>

<p>Nov 21. Turning yellow. <a href="large/20141121.jpg" target=_blank>Large</a>
<br /><img src=2014/20141121.jpg alt="Sapphire Lin turning yellow" /></p>

<p>Nov 19. Continuing to sleep in a new environment. <a href="large/20141119.jpg" target=_blank>Large</a>
<br /><img src=2014/20141119.jpg alt="Sapphire Lin continuing to sleep in a new environment" /></p>

<p>Nov 18. Sleeping in mother's bed. <a href="large/20141118.jpg" target=_blank>Large</a>
<br /><img src=2014/20141118.jpg alt="Sapphire Lin sleeping in mother's bed" /></p>

<p>Nov 17. Taking a bath. <a href="large/20141117.jpg" target=_blank>Large</a>
<br /><img src=2014/20141117.jpg alt="Sapphire Lin taking a bath" /></p>

<p>Nov 14. Tring to open an eye. <a href="large/20141114.jpg" target=_blank>Large</a>
<br /><img src=2014/20141114.jpg alt="Sapphire Lin trying to open an eye" /></p>

<p>Nov 13. My 3.50kg red girl. <a href="large/20141113.jpg" target=_blank>Large</a>
<br /><img src=2014/20141113.jpg alt="Sapphire Lin is born" /></p>
END;
}

require('../../php/ui/_disp.php');
?>
