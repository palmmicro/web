<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strDisney = GetPhotoParagraph('2016/20161113.jpg', $bChinese ? '林近岚在香港迪斯尼过两岁生日' : 'Mia 2 years birthday in Hong Kong Disneyland', $bChinese);
	
    echo <<<END
$strDisney
END;
}

?>
