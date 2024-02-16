<?php
require_once('_mia.php');

function ImgMiaChineseNewYear($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20240210/mmexport1707577854407.jpg', ($bChinese ? '在陌生的长沙过春节' :  'Lost in translation'), $bChinese);
}

function EchoAll($bChinese)
{
	$strChineseNewYear = GetPhotoDirParagraph(20240210, 'ImgMiaChineseNewYear', $bChinese, ($bChinese ? '疫情后第一次回长沙过年，林九霞拍摄。' : 'Chinese New Year holidays in Changsha'));
	
    echo <<<END
$strChineseNewYear
END;
}


?>
