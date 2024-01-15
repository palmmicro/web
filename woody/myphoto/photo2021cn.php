<?php
require('php/_photo2021.php');

function GetMetaDescription()
{
	return 'Woody的2021年个人图片和相关链接。包括新VIVO手机测试照等。从2014年开始的相片中很多都带着女儿林近岚了，看到哪一年她会开始拒绝吧。';
}

function EchoAll()
{
	$strVivo = Img20210207();
	
    echo <<<END
$strVivo
END;
}

require('../../php/ui/_dispcn.php');
?>
