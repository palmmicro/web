<?php
require_once('_myphoto.php');

function ImgMiaDad($bChinese = true)
{
	return ImgAutoQuote('/woody/image/20141211/IMG_5889.JPG', '跟沾光的爸爸合影', 'Sapphire Lin in red hat and red dot dress with Woody', $bChinese);
}

function GetMiaDadParagraph($bChinese = true)
{
	$strLink = GetMia30DaysLink($bChinese);
	return GetPhotoDirParagraph(20141211, 'ImgMiaDad', $bChinese, $strLink.'艺术照', 'Mia '.$strLink);
}

?>
