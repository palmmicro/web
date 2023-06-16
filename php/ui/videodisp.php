<?php

/*
<video width="720" height="1280" controls>
	<source src="../blog/photo/sz161130.mp4" type="video/mp4">
	你的浏览器不支持video标签
</video>
*/

function GetVideoParagraph($strPathName, $iWidth, $iHeight, $strTextCn, $strTextUs = '', $bChinese = true)
{
	$iScreenWidth = LayoutScreenWidthOk();
	
	if (!$iScreenWidth || $iScreenWidth < $iWidth)	return '';
	
	$strVideo = GetHtmlElement('<source src="'.$strPathName.'" type="video/mp4">', 'video', array('width' => GetDoubleQuotes(strval($iWidth)), 'height' => GetDoubleQuotes(strval($iHeight)), 'controls' => false));   
   	$strText = $bChinese ? $strTextCn : $strTextUs;
	return GetHtmlElement($strText.GetBreakElement().$strVideo);
}

function VideoSZ161130($bChinese = true)
{
	return GetVideoParagraph('/woody/blog/photo/sz161130.mp4', 720, 1280, '关于SZ161130的直播视频', 'SZ161130 video', $bChinese);
}

?>
