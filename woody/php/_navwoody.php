<?php
// Provide enhanced function replacement of ../woody.js
require_once('/php/menu.php');

function GetBlogMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('ar1688' => 'AR1688', 'entertainment' => '娱乐',          'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    else              $arName = array('ar1688' => 'AR1688', 'entertainment' => 'Entertainment', 'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    return $arName;
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
    if ($bChinese)  $arName = array('index' => '网络日志', 'image' => '相片',  'res' => '资源共享'); 
    else              $arName = array('index' => 'Blog',     'image' => 'Image', 'res' => 'Resources');
    
    HtmlMenuItem($arName, $iLevel, $strItem, $bChinese);
}

?>
