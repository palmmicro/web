<?php
require_once('_mia.php');

function ImgMiaEightBirthday($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20221113/IMG_20221113_195617.jpg', ($bChinese ? '吹灭八岁的生日蜡烛' :  'Blowing out eight birthday candles'), $bChinese);
}

function ImgMiaLittleKitty($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20220727/IMG_20220727_141803.jpg', ($bChinese ? '黄石捡的小野猫' :  'Little wild kitty picked up in Huangshi'), $bChinese);
}

function ImgMiaMagneticBlock($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20220625/zz10122949-135.jpg', ($bChinese ? '从小到大就这磁力片玩得最长久' :  'Magneitic block is the most durable toy'), $bChinese);
}

function EchoAll($bChinese)
{
	$strEightBirthday = GetPhotoDirParagraph(20221113, 'ImgMiaEightBirthday', $bChinese, ($bChinese ? '疫情第三年下的八岁生日，家附近的皇庭V酒店自助餐。' : 'Eighth birthday in the third year of COVID-19, buffet at nearby Huangting V Hotel.'));
	$strLittleKitty = GetPhotoDirParagraph(20220727, 'ImgMiaLittleKitty', $bChinese, ($bChinese ? '从江西武宁到安徽霍邱途径湖北黄石时捡了一只小野猫带回了深圳' : 'Picked up a small wild kitty and brought it back to Shenzhen while passing through Huangshi, Hubei.'));
	$strMagneticBlock = GetPhotoDirParagraph(20220625, 'ImgMiaMagneticBlock', $bChinese, ($bChinese ? '幼儿园同学家买一送一的phototalk studio艺术照，额外花好几千选片不说，居然都一张免费打印的都不送！' : 'Phototalk studio buy one get one free, paid extra photo selection cost with not a single free print!'));
	
    echo <<<END
$strEightBirthday    
$strLittleKitty
$strMagneticBlock
END;
}


?>
