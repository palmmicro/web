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

function WoodyMenuItem($iLevel, $strItem, $bChinese)
{
    if ($bChinese)  $arName = array('blog' => '网络日志', 'image' => '相片',  'video' => '视频',  'favorite' => '收藏',     'res' => '资源共享',  'separator' => '', 'contact' => '联系我'); 
    else              $arName = array('blog' => 'Blog',     'image' => 'Image', 'video' => 'Video', 'favorite' => 'Favorite', 'res' => 'Resources', 'separator' => '', 'contact' => 'Contact');
    
    HtmlMenuItem($arName, $iLevel, $strItem, $bChinese);
}

?>
