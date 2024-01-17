<?php
require('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2014 personal photos and related links. Including sunshine on my shoulders in Mei Lin, and the testing shot after my daughter was born.';
}

function EchoAll($bChinese)
{
	$strMia = GetBlogPictureParagraph(20141204, 'ImgWorriedWoody', $bChinese, 'by Xiao Xi on '.GetPhotoDirLink(20141121, true, $bChinese));
	$strDad = GetPhotoDirLink(20141211, true, $bChinese).' Sapphire <a href="../mia/photo30days.php">30 Days</a> '.ImgAutoQuote('/woody/image/20141211/IMG_5889.JPG', '', 'Sapphire Lin in red hat and red dot dress with Woody', $bChinese);
	
    echo <<<END
<p><a href="http://www.doyouhike.net/forum/leisure/1013822,0,0,1.html" target=_blank>Jan 11</a>. Sunshine on my shoulders. <a href="2014/large/sunshine.jpg" target=_blank>Large</a>
<br /><img src=2014/sunshine.jpg alt="Sunshine on my shoulders in Mei Lin" /></p>

<p>Nov 16. When a child is born. <a href="2014/large/hospital.jpg" target=_blank>Large</a>
<br /><img src=2014/hospital.jpg alt="In the hospital where Sapphire was born" /></p>

$strMia
<p>$strDad</p>
END;
}

require('../../php/ui/_disp.php');
?>
