<?php
require('php/_php30days.php');

function GetTitle()
{
	return '林近岚满月艺术照 - 豹纹系列';
}

function GetMetaDescription()
{
	return '林近岚(英文名Sapphire)的满月艺术照. 豹纹系列. 2014年12月12号由深圳远东妇儿科医院馨月馆月子中心的专业摄影师拍摄和处理. 大家看看值多少钱, 我反正觉得超级不值!';
}

function EchoAll()
{
    echo <<<END
<p>跟来福合影. <a href="../30days/large/leopard_puppy2.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard_puppy2.jpg alt="Sapphire Lin with puppy." /></p>

<p>我跟来福像不像? <a href="../30days/large/leopard_puppy3.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard_puppy3.jpg alt="Sapphire Lin with puppy. Do I look like this puppy?" /></p>

<p>靠太近了吧! <a href="../30days/large/leopard_puppy4.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard_puppy4.jpg alt="Sapphire Lin with puppy. Too close!" /></p>

<p>笑意. <a href="../30days/large/leopard_puppy.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard_puppy.jpg alt="Sapphire Lin with puppy, smiling." /></p>

<p>拍照真是一件累人的事情. <a href="../30days/large/leopard.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard.jpg alt="Sapphire Lin dress in leopard, tired." /></p>

<p>半身照. <a href="../30days/large/leopard2.jpg" target=_blank>放大</a>
<br /><img src=../30days/leopard2.jpg alt="Sapphire Lin dress in leopard, half view." /></p>
END;
}

require('../../../php/ui/_dispcn.php');
?>
