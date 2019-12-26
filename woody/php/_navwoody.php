<?php
// Provide enhanced function replacement of ../woody.js
require_once('/php/nav.php');

function HtmlMenuItem($arName, $iLevel, $strItem, $bChinese)
{
    foreach ($arName as $strKey => $strDisplay)
    {
        if ($strItem == $strKey)
        {
          	NavWriteItemLink($iLevel, $strItem, ($bChinese ? URL_CNHTML : URL_HTML), $strDisplay);
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
