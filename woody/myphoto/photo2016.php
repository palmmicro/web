<?php
require_once('php/_myphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Woody 2016 personal photos and related links. Including Mia in Hong Kong Disneyland.';
}

function EchoAll($bChinese)
{
	$strDisney = GetPhotoParagraph('2016/20161113.jpg', 'Mia 2 years birthday in Hong Kong Disneyland', $bChinese);
	
    echo <<<END
$strDisney
END;
}

require('../../php/ui/_disp.php');
?>
