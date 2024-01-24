<?php
require_once('php/_yellow.php');

function EchoAll($bChinese)
{
	$strYellowAll = PhotoMiaYellowAll($bChinese);
	$strYellow = PhotoMiaYellow($bChinese);
	$strYellowHalf = PhotoMiaYellowHalf($bChinese);
	$strYellowFull = PhotoMiaYellowFull($bChinese);
	$strYellowTired = PhotoMiaYellowTired($bChinese);
	$strYellowUnhappy = PhotoMiaYellowUnhappy($bChinese);
	$strYellowLeft = PhotoMiaYellowLeft($bChinese);
	$strYellowRight = PhotoMiaYellowRight($bChinese);
	$strYellowBetter = PhotoMiaYellowBetter($bChinese);
	
    echo <<<END
$strYellowAll
$strYellow
$strYellowHalf
$strYellowFull
$strYellowTired
$strYellowUnhappy
$strYellowLeft
$strYellowRight
$strYellowBetter
<p>Ok, this is better. <a href="../30days/large/knit_flower8.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower8.jpg alt="Sapphire Lin dress in yellow knit with pink flower. Ok, this is better." /></p>

<p>But it is really to much! <a href="../30days/large/knit_flower9.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower9.jpg alt="Sapphire Lin dress in yellow knit with pink flower. But it is really to much!" /></p>

<p>I really hate the flower, where is my puppy? <a href="../30days/large/knit3.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit3.jpg alt="Sapphire Lin dress in yellow knit. I really hate the flower, where is my puppy?" /></p>

<p>I am confused. <a href="../30days/large/knit2.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit2.jpg alt="Sapphire Lin dress in yellow knit. I am confused" /></p>

<p>I am protesting now! <a href="../30days/large/knit.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit.jpg alt="Sapphire Lin dress in yellow knit. I am protesting now!" /></p>
END;
}

require('../../../php/ui/_disp.php');
?>
