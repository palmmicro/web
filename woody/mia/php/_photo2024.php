<?php
require_once('_mia.php');

function ImgMiaChineseNewYear($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20240210/mmexport1707577854407.jpg', ($bChinese ? '在陌生的长沙过春节' :  'Lost in translation'), $bChinese);
}

function VidMiaFireworks($bChinese = true)
{
	return GetVideoControl('/woody/image/20240214/mmexport1707872481031.mp4', ($bChinese ? '小心翼翼放烟花' : 'Play fireworks carefully'), $bChinese);
}

function EchoAll($bChinese)
{
	$strFireworks = GetPhotoDirParagraph(20240214, 'VidMiaFireworks', $bChinese, ($bChinese ? '跟小姨奶奶家的聚会，刘瑞翔拍摄。' : "Party with dad's aunt family"));
	$strChineseNewYear = GetPhotoDirParagraph(20240210, 'ImgMiaChineseNewYear', $bChinese, ($bChinese ? '疫情后第一次回长沙过年，林九霞拍摄。' : 'Chinese New Year holidays in Changsha'));
	
    echo <<<END
$strFireworks
$strChineseNewYear
END;
}

?>
