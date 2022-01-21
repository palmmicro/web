<?php
require('php/_php30days.php');

function EchoTitle()
{
    echo '林近岚满月艺术照 - 小红帽系列';
}

function EchoMetaDescription()
{
	echo '林近岚(英文名Sapphire)的满月艺术照. 小红帽系列. 2014年12月12号由深圳远东妇儿科医院馨月馆月子中心的专业摄影师拍摄和处理. 大家看看值多少钱, 我反正觉得超级不值!';
}

function EchoAll()
{
    echo <<<END
<p>小红帽和来福. <a href="../30days/large/hat_puppy2.jpg" target=_blank>放大</a>
<br /><img src=../30days/hat_puppy2.jpg alt="Sapphire Lin in red hat with puppy." /></p>

<p>半身照. <a href="../30days/large/hat_puppy.jpg" target=_blank>放大</a>
<br /><img src=../30days/hat_puppy.jpg alt="Sapphire Lin in red hat with puppy, half view." /></p>

<p>疑惑中. <a href="../30days/large/hat_puppy3.jpg" target=_blank>放大</a>
<br /><img src=../30days/hat_puppy3.jpg alt="Sapphire Lin in red hat with puppy, wondering." /></p>

<p>来福丢了. <a href="../30days/large/hat.jpg" target=_blank>放大</a>
<br /><img src=../30days/hat.jpg alt="Sapphire Lin in red hat." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
