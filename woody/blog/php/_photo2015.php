<?php
require_once('_blogphoto.php');

function EchoAll($bChinese)
{
	$strLenna = GetBlogPictureParagraph(20150818, 'ImgCompleteLenna', $bChinese);
	
    echo <<<END
$strLenna
END;
}

?>
