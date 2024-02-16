<?php
require_once('_mia.php');

function ImgMiaRhythmicGymnastics($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20230826/wx_camera_1693023232415.jpg', ($bChinese ? '快卸妆完了才想起来拍张照片' :  'Must be hard being a queen'), $bChinese);
}

function EchoAll($bChinese)
{
	$strRhythmicGymnastics = GetPhotoDirParagraph(20230826, 'ImgMiaRhythmicGymnastics', $bChinese, ($bChinese ? '在顺德参加第一次艺术体操比赛' : 'Rhythmic gymnastics competition for the first time'));
	
    echo <<<END
$strRhythmicGymnastics
END;
}

?>
