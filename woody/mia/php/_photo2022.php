<?php
require_once('_mia.php');

function ImgMiaMagneticBlock($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20220625/zz10122949-135.jpg', ($bChinese ? '从小到大就这磁力片玩得最长久' :  'Magneitic block is the most durable toy'), $bChinese);
}

function EchoAll($bChinese)
{
	$strMagneticBlock = GetPhotoDirParagraph(20220625, 'ImgMiaMagneticBlock', $bChinese, ($bChinese ? '幼儿园同学家买一送一的phototalk studio艺术照，额外花好几千选片不说，居然都一张免费打印的都不送！' : 'Phototalk studio buy one get one free, paid extra photo selection cost with not a single free print!'));
	
    echo <<<END
$strMagneticBlock
END;
}


?>
