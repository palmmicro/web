<?php
require('php/_woody.php');

function GetTitle($bChinese)
{
	return "Woody's Image";
}

function GetMetaDescription($bChinese)
{
	return "List and classification of all Woody's image, including my daughter Sapphire and blog pictures, with my precious bike photo taken in early spring 2007.";
}

function EchoAll($bChinese)
{
	$strMyPhoto = GetMyPhotoLinks($bChinese);
	$strMiaPhoto = GetMiaPhotoLinks($bChinese);
	$strBlogPhoto = GetBlogPhotoLinks($bChinese);
	$strImage = ImgWoodyBike($bChinese);
	
	$strMia = GetBlogLink(20141204, $bChinese);
	
    echo <<<END
<p>Album of myself: $strMyPhoto
</p>

<p>Album of $strMia: <a href="mia/photo30days.php">30 Days</a> $strMiaPhoto
</p>

<p>Blog pictures: $strBlogPhoto
</p>

<p>$strImage
</p>
END;
}

require('../php/ui/_disp.php');
?>
