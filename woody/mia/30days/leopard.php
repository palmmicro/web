<?php
require('php/_php30days.php');

function EchoAll($bChinese)
{
    echo <<<END
<p>With puppy. <a href="../30days/large/leopard_puppy2.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard_puppy2.jpg alt="Sapphire Lin with puppy." /></p>

<p>Do I look like this puppy? <a href="../30days/large/leopard_puppy3.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard_puppy3.jpg alt="Sapphire Lin with puppy. Do I look like this puppy?" /></p>

<p>Too close! <a href="../30days/large/leopard_puppy4.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard_puppy4.jpg alt="Sapphire Lin with puppy. Too close!" /></p>

<p>Smiling. <a href="../30days/large/leopard_puppy.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard_puppy.jpg alt="Sapphire Lin with puppy, smiling." /></p>

<p>Tired. <a href="../30days/large/leopard.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard.jpg alt="Sapphire Lin dress in leopard, tired." /></p>

<p>Half view. <a href="../30days/large/leopard2.jpg" target=_blank>Large</a>
<br /><img src=../30days/leopard2.jpg alt="Sapphire Lin dress in leopard, half view." /></p>
END;
}

require('../../../php/ui/_disp.php');
?>
