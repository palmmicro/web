<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2010 blog. Including AR168DS programmer image and Soyo G1681 front view etc.';
}

function EchoAll($bChinese)
{
	$strLenna = ImgCompleteLenna($bChinese);
	$strPHP = GetHtmlElement('Sep 5 My First '.GetBlogLink(20100905, $bChinese).' Application '.ImgPhpBest($bChinese));
	
    echo <<<END
<p>Dec 2 <a href="ar1688/20101202.php">Writing Program Flash</a>
<br /><img src=photo/20101202.jpg></p>

<p>Sep 7 <a href="pa1688/20100907.php">A Hard Day's Night</a>
<br /><img src=../../pa1688/user/g1681/soyo.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway front view." /></p>

$strPHP

<p>Jul 26 <a href="entertainment/20100726.php">Raw Video Viewers</a>
<br /><img src=photo/20100726.jpg alt="Screen shot of Speech Workshop, Raw Image Viewer and CamMan" />
$strLenna
</p>

<p>May 29 My First <a href="entertainment/20100529.php">Visual C++</a> 2008 Application
<br /><img src=photo/20100529.jpg alt="Screen shot of My First Visual C++ 2008 Application Woody's Web Tool" /></p>

<p>Apr 27 <a href="palmmicro/20100427.php">The Blocking History of Palmmicro.com</a>
<br /><img src=photo/20100813.jpg alt="Beijing Simatai part of the Great Wall of China" /></p>
END;
}

require('../../php/ui/_disp.php');
?>
