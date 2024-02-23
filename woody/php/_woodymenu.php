<?php

function GetMyPhotoYears()
{
	return array(2006, 2007, 2008, 2009, 2010, 2011, 2012, 2014, 2015, 2016, 2020, 2021, 2023);
}

function GetMiaPhotoYears()
{
	return array(2014, 2015, 2016, 2018, 2022, 2023, 2024);
}

function GetBlogPhotoYears()
{
/*	$ar = array();
	for ($i = 2006; $i <= 2016; $i ++)	$ar[] = $i;
	return $ar;*/
	return array(2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2020, 2023);
}

function GetPhotoPageArray($arYears)
{
	$arPhoto = array();
	foreach ($arYears as $iYear)
	{
		$arPhoto[] = 'photo'.strval($iYear);
	}
	return $arPhoto;
}

function GetPhotoMenuArray($arYears)
{
	$arPhoto = array();
	foreach ($arYears as $iYear)
	{
		$strYear = strval($iYear);
		$arPhoto['photo'.$strYear] = $strYear;	// substr($strYear, -2, 2);
	}
	return $arPhoto;
}

function GetBlogPhotoLinks($bChinese = true)
{
	return GetCategoryLinks(GetPhotoMenuArray(GetBlogPhotoYears()), PATH_BLOG, $bChinese);
}

function GetMyPhotoLinks($bChinese = true)
{
	return GetCategoryLinks(GetPhotoMenuArray(GetMyPhotoYears()), '/woody/myphoto/', $bChinese);
}

function GetMiaPhotoLinks($bChinese = true)
{
	return GetCategoryLinks(GetPhotoMenuArray(GetMiaPhotoYears()), '/woody/mia/', $bChinese);
}

function GetMia30DaysDisplay($bChinese = true)
{
	return $bChinese ? '满月' : '30 Days';
}

define('PATH_MIA_30DAYS', '/woody/mia/30days/');
function GetMia30DaysLink($bChinese = true)
{
	return GetPageLink(PATH_MIA_30DAYS, 'index', false, GetMia30DaysDisplay($bChinese), $bChinese);
}

function GetBlogMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('ar1688' => 'AR1688', 'entertainment' => '娱乐',          'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    else              $arName = array('ar1688' => 'AR1688', 'entertainment' => 'Entertainment', 'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    return $arName;
}

function GetBlogMenuLinks($bChinese = true)
{
	return GetCategoryLinks(GetBlogMenuArray($bChinese), PATH_BLOG, $bChinese);
}

function LayoutWoodyMenuArray($bChinese)
{
	LayoutBegin();
	EchoParagraph(GetCategoryLinks(GetWoodyMenuArray($bChinese), '/woody/', $bChinese));
	LayoutEnd();
}

function LayoutBlogMenuArray($bChinese)
{
	LayoutBegin();
	EchoParagraph(GetBlogMenuLinks($bChinese));
	LayoutEnd();
	
	LayoutWoodyMenuArray($bChinese);
}

function LayoutMiaPhotoArray($bChinese)
{
	LayoutBegin();
	EchoParagraph(GetMiaPhotoLinks($bChinese));
	LayoutEnd();

	LayoutWoodyMenuArray($bChinese);
}

/*
function UrlGetHtml($bChinese = true)
{
    return $bChinese ? 'cn.html' : '.html';
}

function HtmlMenuItem($arName, $iLevel, $strItem, $bChinese)
{
    foreach ($arName as $strKey => $strDisplay)
    {
        if ($strItem == $strKey)
        {
          	MenuWriteItemLink($iLevel, $strItem, UrlGetHtml($bChinese), $strDisplay);
        	break;
        }
    }
}
*/

function PhpMenuItem($arName, $iLevel, $strItem, $bChinese)
{
    foreach ($arName as $strKey => $strDisplay)
    {
        if ($strItem == $strKey)
        {
          	MenuWriteItemLink($iLevel, $strItem, UrlGetPhp($bChinese), $strDisplay);
        	break;
        }
    }
}

function GetWoodyMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('index' => '资源共享', 'image' => '相片',  'blog' => '网络日志'); 
    else              $arName = array('index' => 'Resource', 'image' => 'Image', 'blog' => 'Blog');
    return $arName;
}

function WoodyMenuItem($iLevel, $strItem, $bChinese = true)
{
//    HtmlMenuItem(GetWoodyMenuArray($bChinese), $iLevel, $strItem, $bChinese);
    PhpMenuItem(GetWoodyMenuArray($bChinese), $iLevel, $strItem, $bChinese);
}

?>
