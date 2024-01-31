<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strVivo = GetPhotoParagraph('2021/20210207.jpg', $bChinese ? '新VIVO手机测试照' : 'Test photo of my new VIVO phone', $bChinese);
	
    echo <<<END
$strVivo
END;
}

?>
