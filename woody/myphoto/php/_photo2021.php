<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strMarriot = GetPhotoParagraph('2021/IMG_20210908_193414.jpg', $bChinese ? '疫情下学校不让离开深圳。错峰开学前，大鹏半岛的万豪里全是娃的老师和同学们。' : "Can't leave Shenzhen due to COVID-19, the Marriott in Dapeng Peninsula was full of Mia's teacher and classmates before school opening.", $bChinese);
	$strVivo = GetPhotoParagraph('2021/IMG_20210207_143853.jpg', $bChinese ? '新VIVO手机测试照' : 'Test photo of my new VIVO phone', $bChinese);
	
    echo <<<END
$strMarriot    
$strVivo
END;
}

?>
