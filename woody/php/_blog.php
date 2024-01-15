<?php
require_once('_woody.php');

function GetBlogYearTags()
{
	$ar = array();
	foreach (GetBlogPhotoYears() as $iYear)
	{
		$ar[$iYear] = '<br />'.GetRemarkElement(GetNameTag(strval($iYear)));
	}
	return $ar;
}

function GetBlogYearLinks()
{
	$str = '';
	foreach (GetBlogPhotoYears() as $iYear)
	{
		$str .= GetNameLink(strval($iYear)).' ';
	}
	return $str;
}

?>
