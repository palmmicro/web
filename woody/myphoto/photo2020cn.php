<?php
require('php/_photo2020.php');

function GetMetaDescription()
{
	return 'Woody的2020年个人图片和相关链接。包括雪球嘉年华等。从2014年开始的相片中很多都带着女儿林近岚了，看到哪一年她会开始拒绝吧。';
}

function EchoAll()
{
	$strXueqiu = Img20201205();
	
    echo <<<END
$strXueqiu
END;
}

require('../../php/ui/_dispcn.php');
?>
