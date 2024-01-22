<?php
require('php/_php30days.php');

function EchoAll($bChinese)
{
    echo <<<END
<p>Thinking. <a href="../30days/large/green4.jpg" target=_blank>Large</a>
<br /><img src=../30days/green4.jpg alt="Sapphire Lin thinking." /></p>

<p>Crown. <a href="../30days/large/green3.jpg" target=_blank>Large</a>
<br /><img src=../30days/green3.jpg alt="Sapphire Lin with crown." /></p>

<p>Half view. <a href="../30days/large/green2.jpg" target=_blank>Large</a>
<br /><img src=../30days/green2.jpg alt="Sapphire Lin with crown, half view." /></p>

<p>Full view. <a href="../30days/large/green.jpg" target=_blank>Large</a>
<br /><img src=../30days/green.jpg alt="Sapphire Lin with crown, full view." /></p>
END;
}

require('../../../php/ui/_disp.php');
?>
