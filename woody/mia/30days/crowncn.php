<?php
require('php/_php30days.php');

function EchoAll()
{
    echo <<<END
<p>第一次认真思考人生. <a href="../30days/large/green4.jpg" target=_blank>放大</a>
<br /><img src=../30days/green4.jpg alt="Sapphire Lin thinking." /></p>

<p>花冠. <a href="../30days/large/green3.jpg" target=_blank>放大</a>
<br /><img src=../30days/green3.jpg alt="Sapphire Lin with crown." /></p>

<p>半身照. <a href="../30days/large/green2.jpg" target=_blank>放大</a>
<br /><img src=../30days/green2.jpg alt="Sapphire Lin with crown, half view." /></p>

<p>全身照. <a href="../30days/large/green.jpg" target=_blank>放大</a>
<br /><img src=../30days/green.jpg alt="Sapphire Lin with crown, full view." /></p>
END;
}

require('../../../php/ui/_dispcn.php');
?>
