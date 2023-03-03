<?php
require('php/_res.php');

function GetTitle($bChinese)
{
	return 'Cat Eyes in Seattle';
}

function GetMetaDescription($bChinese)
{
	return 'Taobao store Cat Eyes in Seattle introduction with some jewelry and models display, including a Scottish fold female cat and a British shorthair male cat.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Taobao store <a href="http://shop58325285.taobao.com/" target=_blank>link</a></p>

<p>Natural cat's eye <a href="cateyes/alexandrite389.php">alexandrite 3.89ct</a>
<br /><img src=cateyes/alexandrite/389/naturelight.jpg alt="alexandrite cat eye 3.89ct in nature light" /></p>

<p>Natural cat's eye <a href="cateyes/emerald594.php">emerald 5.94ct</a>
<br /><img src=cateyes/emerald/594/ring.jpg alt="emerald cat eye 5.94ct on ring" /></p>

<p>Model <a href="cateyes/baozi.php">Baozi</a>
<br /><img src=cateyes/models/baozi/emerald.jpg alt="Scottish fold female cat with emerald" /></p>

<p>Model <a href="cateyes/baozi.php">Baozi</a> and Duoduo <a href="cateyes/models/baozi/large/srilanka.jpg" target=_blank>Large</a>
<br /><img src=cateyes/models/baozi/srilanka.jpg alt="Scottish fold female cat and British shorthair male cat in front of a Sri Lanka jewelry map" /></p>

<p>July 29, 2012. Shop owner and me in Kuala Lumpur, Malaysia. Photo by CT Khoo <a href="../groupphoto/world/large/KualaLumpur.jpg" target=_blank>Large</a>
<br /><img src=../groupphoto/world/KualaLumpur.jpg alt="Lobster meal at a Chinese restaurant in Kuala Lumpur." /></p>
END;
}

require('../../php/ui/_disp.php');
?>
