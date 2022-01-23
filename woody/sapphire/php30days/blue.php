<?php
require('php/_php30days.php');

function GetTitle($bChinese)
{
	return 'Sapphire 30 Days Photos - Blue Series';
}

function GetMetaDescription($bChinese)
{
	return 'Sapphire 30 days photos. Blue series. Taken by professional photographers from Shenzhen Far East International Medical Center.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Dress in white and blue. <a href="../30days/large/blue.jpg" target=_blank>Large</a>
<br /><img src=../30days/blue.jpg alt="Sapphire Lin dress in white and blue." /></p>

<p>Half view. <a href="../30days/large/blue2.jpg" target=_blank>Large</a>
<br /><img src=../30days/blue2.jpg alt="Sapphire Lin dress in blue and white, half view." /></p>

<p>Full view. <a href="../30days/large/blue3.jpg" target=_blank>Large</a>
<br /><img src=../30days/blue3.jpg alt="Sapphire Lin dress in blue, full view." /></p>

<p>Yawning. <a href="../30days/large/blue4.jpg" target=_blank>Large</a>
<br /><img src=../30days/blue4.jpg alt="Sapphire Lin dress in blue, yawning." /></p>

<p>Sprawling. <a href="../30days/large/blue5.jpg" target=_blank>Large</a>
<br /><img src=../30days/blue5.jpg alt="Sapphire Lin dress in blue, sprawling." /></p>
END;
}

require('/php/ui/_disp.php');
?>
