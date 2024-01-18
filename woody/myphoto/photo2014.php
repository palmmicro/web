<?php
require_once('php/_photo2014.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2014 personal photos and related links. Including sunshine on my shoulders in Mei Lin, and the testing shot after my daughter was born.';
}

function EchoAll($bChinese)
{
	$strMia = PhotoMia($bChinese);
	$strMiaDad = PhotoMiaDad($bChinese);
	
    echo <<<END
<p><a href="http://www.doyouhike.net/forum/leisure/1013822,0,0,1.html" target=_blank>Jan 11</a>. Sunshine on my shoulders. <a href="2014/large/sunshine.jpg" target=_blank>Large</a>
<br /><img src=2014/sunshine.jpg alt="Sunshine on my shoulders in Mei Lin" /></p>

<p>Nov 16. When a child is born. <a href="2014/large/hospital.jpg" target=_blank>Large</a>
<br /><img src=2014/hospital.jpg alt="In the hospital where Sapphire was born" /></p>

$strMia
$strMiaDad
END;
}

require('../../php/ui/_disp.php');
?>
