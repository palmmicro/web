<?php
require_once('_myphoto.php');

function ImgWoodyMiaFourier($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20211218/IMG_20211218_171847.jpg', ($bChinese ? '张牙舞爪' :  'Mia showing her teeth and claws'), $bChinese);
}

function EchoAll($bChinese)
{
	$strMiaFourier = GetPhotoDirParagraph(20211218, 'ImgWoodyMiaFourier', $bChinese, ($bChinese ? '溜娃进了傅立叶科学鹦鹉，热情的小姑娘主动帮我们拍了几张合影。' : 'Photo taken at Fourier Scientific Parrot, a coffee shop hidden inside.'));
	$strMarriot = GetPhotoParagraph('2021/IMG_20210908_193414.jpg', $bChinese ? '疫情下学校不让离开深圳。错峰开学前，大鹏半岛的万豪里全是娃的老师和同学们。' : "Can't leave Shenzhen due to COVID-19, the Marriott in Dapeng Peninsula was full of Mia's teacher and classmates before school opening.", $bChinese);
	$strVivo = GetPhotoParagraph('2021/IMG_20210207_143853.jpg', $bChinese ? '新VIVO手机测试照' : 'Test photo of my new VIVO phone', $bChinese);
	
    echo <<<END
$strMiaFourier
$strMarriot    
$strVivo
END;
}

?>
