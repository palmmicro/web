<?php
require_once('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2021 personal photos and related links. Including test photo of my new VIVO phone.';
}

function EchoAll($bChinese)
{
	$strVivo = GetPhotoParagraph('2021/20210207.jpg', 'Test photo of my new VIVO phone', $bChinese);
	
    echo <<<END
$strVivo
END;
}

require('../../php/ui/_disp.php');
?>
