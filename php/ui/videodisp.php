<?php

/*
<video width="720" height="1280" controls poster="../blog/photo/20200915.jpg">
	<source src="../blog/photo/sz161130.mp4" type="video/mp4">
	你的浏览器不支持video标签
</video>
*/

function GetVideoParagraph($strPathName, $iWidth, $iHeight, $strPosterFile, $strText = '', $bChinese = true)
{
	if (LayoutGetDisplayWidth() < $iWidth)
	{
		$str = GetFileLink($strPathName);
	}
	else
	{
		$strVideo = GetHtmlElement('<source src="'.$strPathName.'" type="video/mp4">', 'video', array('width' => GetDoubleQuotes(strval($iWidth)), 'height' => GetDoubleQuotes(strval($iHeight)), 'controls' => false, 'poster' => GetDoubleQuotes($strPosterFile)));   
		$str = $strText.GetBreakElement().$strVideo;
	}
	return GetHtmlElement($str);
}

function VideoSZ161130($bChinese = true)
{
	return GetVideoParagraph(PATH_BLOG_PHOTO.'sz161130.mp4', 720, 1280, PATH_BLOG_PHOTO.'20200915.jpg', ($bChinese ? '关于SZ161130的直播视频' : 'SZ161130 video'), $bChinese);
}

?>
