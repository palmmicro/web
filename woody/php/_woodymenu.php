<?php
// Provide enhanced function replacement of ../woody.js

function GetBlogMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('ar1688' => 'AR1688', 'entertainment' => '娱乐',          'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    else              $arName = array('ar1688' => 'AR1688', 'entertainment' => 'Entertainment', 'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    return $arName;
}

function EchoBlogMenuArray($bChinese)
{
	LayoutBegin();
	$str = GetCategoryLinks(GetBlogMenuArray($bChinese), '/woody/blog/', $bChinese);
    EchoParagraph($str);
	LayoutEnd();
}

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

function WoodyMenuItem($iLevel, $strItem, $bChinese = true)
{
    if ($bChinese)  $arName = array('index' => '资源共享', 'image' => '相片',  'blog' => '网络日志'); 
    else              $arName = array('index' => 'Resource', 'image' => 'Image', 'blog' => 'Blog');
    
    HtmlMenuItem($arName, $iLevel, $strItem, $bChinese);
}

?>
