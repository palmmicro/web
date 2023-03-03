<?php
require('php/_cateyes.php');

function GetTitle($bChinese)
{
	return 'Cat Eye Model Baozi';
}

function GetMetaDescription($bChinese)
{
	return 'Scottish fold female cat model Baozi in Taobao store Cat Eyes in Seattle, with pictures of emerald and taking a most hated shower in Beijing.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Born: Aug 3, 2011
<br />Birthplace: Beijing
<br />Sex: Female
<br />Bread: Scottish Fold
</p>

<p>Emerald <a href="models/baozi/large/emerald.jpg" target=_blank>Large</a>
<br /><img src=models/baozi/emerald.jpg alt="Scottish fold female cat with emerald" /></p>

<p>Mostly hated picture of Beijing Baozi <a href="../../blog/photo/large/20120420.jpg" target=_blank>Large</a>
<br /><img src=../../blog/photo/20120420.jpg alt="Scottish fold female cat taking a shower" /></p>
END;
}

require('../../../php/ui/_disp.php');
?>
