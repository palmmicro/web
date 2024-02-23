<?php
require_once('_myphoto.php');

function EchoAll($bChinese)
{
	$strTsinghuaMotto = GetPhotoParagraph('2023/IMG_20231005_154925.jpg', $bChinese ? '去小鸟天堂路上途径梁启超故居，小朋友听说这是清华校训，一定要给爸爸拍一张。' : 'On the way to Bird Paradise, we passed by the former residence of Liang Qichao. Mia heard that this was the motto of Tsinghua University and insisted to take a picture for me.', $bChinese);
	$strZhongShan = GetPhotoParagraph('2023/20231005.jpg', $bChinese ? '中山市博物馆的仿古摄影' : 'Antique Photography at Zhongshan Museum', $bChinese);
	
    echo <<<END
$strTsinghuaMotto
$strZhongShan
END;
}

?>
