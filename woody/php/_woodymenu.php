<?php
// Provide enhanced function replacement of ../woody.js

function GetBlogMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('ar1688' => 'AR1688', 'entertainment' => '娱乐',          'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    else              $arName = array('ar1688' => 'AR1688', 'entertainment' => 'Entertainment', 'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    return $arName;
}

function GetBlogMenuLinks($bChinese = true)
{
	return GetCategoryLinks(GetBlogMenuArray($bChinese), '/woody/blog/', $bChinese);
}

function EchoBlogMenuArray($bChinese)
{
	LayoutBegin();
	EchoParagraph(GetBlogMenuLinks($bChinese).'<br />'.GetWoodyMenuLinks($bChinese));
	LayoutEnd();
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

function GetWoodyMenuLinks($bChinese = true)
{
	return GetCategoryLinks(GetWoodyMenuArray($bChinese), '/woody/', $bChinese);
}

function GetWoodyMenuParagraph($bChinese = true)
{
	return GetHtmlElement(GetWoodyMenuLinks($bChinese));
}


?>
