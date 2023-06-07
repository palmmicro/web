<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2015 blog. Including part of the complete Lenna story etc.';
}

function EchoAll($bChinese)
{
	$strLenna = ImgCompleteLenna($bChinese);
	$strSZ162411 = GetLinkElement('SZ162411', 'entertainment/20150818.php');
	
    echo <<<END
<p>Aug 18 PHP Application to Estimate $strSZ162411 Net Value
$strLenna
</p>
END;
}

require('../../php/ui/_disp.php');
?>
