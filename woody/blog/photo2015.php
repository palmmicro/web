<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2015 blog. Including part of the complete Lenna story etc.';
}

function EchoAll($bChinese)
{
	$strLenna = GetBlogPictureParagraph(20150818, 'ImgCompleteLenna', $bChinese);
	
    echo <<<END
$strLenna
END;
}

require('../../php/ui/_disp.php');
?>
