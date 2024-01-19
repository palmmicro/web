<?php
require_once('php/_myphoto.php');

function GetMetaDescription()
{
	return 'Woody的2021年个人图片和相关链接。包括新VIVO手机测试照等。从2014年开始的相片中很多都带着女儿林近岚了，看到哪一年她会开始拒绝吧。';
}

function EchoAll()
{
	$strVivo = GetPhotoParagraph('2021/20210207.jpg', '新VIVO手机测试照');
	
    echo <<<END
$strVivo
END;
}

require('../../php/ui/_dispcn.php');
?>
