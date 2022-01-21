<?php
require('php/_php30days.php');

function EchoTitle($bChinese)
{
    echo 'Sapphire 30 Days Photos - Red Hat Series';
}

function EchoMetaDescription($bChinese)
{
	echo 'Sapphire 30 days photos. Red Hat series. Taken by professional photographers from Shenzhen Far East International Medical Center.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Red hat with puppy. <a href="../30days/large/hat_puppy2.jpg" target=_blank>Large</a>
<br /><img src=../30days/hat_puppy2.jpg alt="Sapphire Lin in red hat with puppy." /></p>

<p>Half view. <a href="../30days/large/hat_puppy.jpg" target=_blank>Large</a>
<br /><img src=../30days/hat_puppy.jpg alt="Sapphire Lin in red hat with puppy, half view." /></p>

<p>Wondering. <a href="../30days/large/hat_puppy3.jpg" target=_blank>Large</a>
<br /><img src=../30days/hat_puppy3.jpg alt="Sapphire Lin in red hat with puppy, wondering." /></p>

<p>Puppy lost. <a href="../30days/large/hat.jpg" target=_blank>Large</a>
<br /><img src=../30days/hat.jpg alt="Sapphire Lin in red hat." /></p>
END;
}

require('/php/ui/_disp.php');
?>
