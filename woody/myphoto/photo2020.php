<?php
require('php/_photo2020.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2020 personal photos and related links. Including Xueqiu carnival.';
}

function EchoAll($bChinese)
{
	$strXueqiu = Img20201205($bChinese);
	
    echo <<<END
$strXueqiu
END;
}

require('../../php/ui/_disp.php');
?>
