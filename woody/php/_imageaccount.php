<?php

function GetImageParagraph($callbackDate, $iDate, $callbackImg, $bChinese = true, $strExtra = '', $strExtraUs = '')
{
	return GetHtmlElement(call_user_func($callbackDate, $iDate, $bChinese).' '.($bChinese ? $strExtra : $strExtraUs).' '.call_user_func($callbackImg, $bChinese));
}

function GetBlogPictureParagraph($iDate, $callback, $bChinese = true, $strExtra = '', $strExtraUs = '')
{
	return GetImageParagraph('GetBlogTitle', $iDate, $callback, $bChinese, $strExtra, $strExtraUs);
}

function GetPhotoDirParagraph($iDate, $callback, $bChinese = true, $strExtra = '', $strExtraUs = '')
{
	return GetImageParagraph('GetPhotoDirLink', $iDate, $callback, $bChinese, $strExtra, $strExtraUs);
}

function GetMiaParagraph($bChinese = true, $bExtra = true)
{
	$strDir = GetPhotoDirLink(20141121, $bChinese);
	$strExtra = $bExtra ? '小西拍摄于'.$strDir : '';
	$strExtraUs = $bExtra ? 'by Xiao Xi on '.$strDir : '';
	return GetBlogPictureParagraph(20141204, 'ImgWorriedWoody', $bChinese, $strExtra, $strExtraUs);
}

function GetSnowballParagraph($bChinese = true)
{
	return GetBlogPictureParagraph(20201205, 'ImgSnowballCarnival', $bChinese);
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
