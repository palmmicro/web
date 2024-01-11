<?php
require('php/_woody.php');

function GetTitle($bChinese)
{
	return 'Resources Recommended by Woody';
}

function GetMetaDescription($bChinese)
{
	return 'Web development resources, companies founded by family and friends, and software developed by myself.';
}

function EchoAllWoody($bChinese)
{
	$strAccount = GetAccountToolLinks($bChinese);
	$strImage = ImgWoodyHomepage($bChinese);
	
    echo <<<END
<p>My Tool Software
<br />$strAccount
</p>

<p>Companies Founded by Family and Friends
<br />Products of <a href="res/btbond.php">Btbond</a> are displayed here with the request of its founder.
<br /><a href="res/cateyes.php">Cat Eyes in Seattle</a> store runs by my wife, my future Borsheim jewelry store.
</p>

<p>$strImage
</p>
END;
}

require('../php/ui/_disp.php');
?>
