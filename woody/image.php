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
	
    echo <<<END
<p>Album of myself: $strMyPhoto
</p>

<p>Album of <a href="blog/entertainment/20141204.php">Sapphire</a>: <a href="sapphire/photo30days.php">30 Days</a> $strMiaPhoto
</p>

<p>Blog pictures: $strBlogPhoto
</p>

<p>$strImage
</p>
END;
}

require('../php/ui/_disp.php');
?>
