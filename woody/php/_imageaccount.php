<?php

function GetImageParagraph($callbackDate, $iDate, $callbackImg, $bChinese = true, $strExtra = '')
{
	return GetHtmlElement(call_user_func($callbackDate, $iDate, $bChinese).' '.$strExtra.' '.call_user_func($callbackImg, $bChinese));
}

function GetBlogPictureParagraph($iDate, $callback, $bChinese = true, $strExtra = '')
{
	return GetImageParagraph('GetBlogTitle', $iDate, $callback, $bChinese, $strExtra);
}

function GetPhotoDirParagraph($iDate, $callback, $bChinese = true, $strExtra = '')
{
	return GetImageParagraph('GetPhotoDirLink', $iDate, $callback, $bChinese, $strExtra);
}

function PhotoMia($bChinese = true, $bExtra = true)
{
	if ($bExtra)
	{
		$strDir = GetPhotoDirLink(20141121, $bChinese);
		$strExtraCn = '小西拍摄于'.$strDir;
		$strExtraUs = 'by Xiao Xi on '.$strDir;
	}
	return GetBlogPictureParagraph(20141204, 'ImgWorriedWoody', $bChinese, ($bExtra ? ($bChinese ? $strExtraCn : $strExtraUs) : ''));
}

function PhotoSnowball($bChinese = true)
{
	return GetBlogPictureParagraph(20201205, 'ImgSnowballCarnival', $bChinese);
}

function VideoNasdaq100($bChinese = true)
{
	return GetHtmlElement(GetBlogTitle(20200915, $bChinese).VideoSZ161130($bChinese));
}

class ImageAccount extends TitleAccount
{
    // photo2006 -> 2006
    function GetPageYear()
    {
    	$strPage = $this->GetPage();
    	$iLen = strlen($strPage) - strlen('photo');
    	return substr($strPage, -$iLen, $iLen);
    }
}

?>
