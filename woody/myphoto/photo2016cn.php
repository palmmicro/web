<?php
require_once('php/_myphoto.php');

function GetMetaDescription()
{
	return 'Woody的2016年个人图片和相关链接。包括香港迪斯尼等。从去年开始的相片中都带着女儿林近岚了，看到哪一年她会开始拒绝吧。';
}

function EchoAll()
{
	$strDisney = GetPhotoParagraph('2016/20161113.jpg', '林近岚在香港迪斯尼过两岁生日');
	
    echo <<<END
$strDisney
END;
}

require('../../php/ui/_dispcn.php');
?>
