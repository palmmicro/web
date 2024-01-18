<?php
require('php/_photo2021.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2021 personal photos and related links. Including test photo of my new VIVO phone.';
}

function EchoAll($bChinese)
{
	$strVivo = Photo20210207($bChinese);
	
    echo <<<END
$strVivo
END;
}

require('../../php/ui/_disp.php');
?>
