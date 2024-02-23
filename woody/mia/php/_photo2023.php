<?php
require_once('_mia.php');

function ImgMiaRhythmicGymnastics($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20230826/wx_camera_1693023232415.jpg', ($bChinese ? '快卸妆完了才想起来拍张照片' :  'Must be hard being a queen'), $bChinese);
}

function ImgMiaGuiLin($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20230808/IMG_20230808_112924.jpg', ($bChinese ? '带着英国小象爬桂林象鼻山' :  'Climb the Elephant Trunk Hill in Guilin with a British elephant toy'), $bChinese);
}

function EchoAll($bChinese)
{
	$strRhythmicGymnastics = GetPhotoDirParagraph(20230826, 'ImgMiaRhythmicGymnastics', $bChinese, ($bChinese ? '在顺德参加第一次艺术体操比赛' : 'Rhythmic gymnastics competition for the first time'));
	$strGuiLin = GetPhotoDirParagraph(20230808, 'ImgMiaGuiLin', $bChinese, ($bChinese ? '从长沙开车到北海途径桂林呆两天' : 'Drive from Changsha to Beihai via Guilin and stay for two days'));
	
    echo <<<END
$strRhythmicGymnastics
$strGuiLin
END;
}

?>
