<?php
require_once('../../../php/layout.php');
require_once('../../../php/bloglink.php');
require_once('../../../php/ui/imagedisp.php');
require_once('../../php/_woodymenu.php');
require_once('_photo.php');

define('PATH_30DAYS', '/woody/mia/30days/');

function Get30DaysMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('blue' => '蓝色', 'hat' => '圣诞小红帽',    'crown' => '王冠',   'yellow' => '黄色',   'leopard' => '豹纹');
    else              $arName = array('blue' => 'Blue', 'hat' => 'Christmas Hat', 'crown' => 'Crown', 'yellow' => 'Yellow', 'leopard' => 'Leopard');
    return $arName;
}

function _menuLoop30Days($bChinese)
{
	$strDisplay = GetMia30DaysDisplay($bChinese);
	$ar30Days = array_keys(Get30DaysMenuArray($bChinese));		// array('blue', 'hat', 'crown', 'yellow', 'leopard'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel + 1, 'image', $bChinese);
	MenuContinueNewLine();
   	MenuWriteItemLink($iLevel - 1, 'index', UrlGetPhp($bChinese), $strDisplay);
	MenuContinueNewLine();
    MenuDirLoop($ar30Days);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoop30Days', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
	LayoutBegin();
	EchoParagraph(GetPhotoDirLink(20141211, $bChinese, false).' '.GetMia30DaysLink($bChinese).' '.GetCategoryLinks(Get30DaysMenuArray($bChinese), PATH_30DAYS, $bChinese));
	LayoutEnd();

	LayoutMiaPhotoArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

function Get30DaysDisplay($strPage, $bChinese = true)
{
	$ar = Get30DaysMenuArray($bChinese);
    if (isset($ar[$strPage]))	return $ar[$strPage].($bChinese ? '系列' : ' Series');
    return false;
}

function GetTitle($bChinese)
{
	global $acct;
	
	$str = $bChinese ? '林近岚' : 'Mia ';
	$str .= GetMia30DaysDisplay($bChinese);
	$str .= $bChinese ? '艺术照' : ' Photos';
	if ($strSeries = Get30DaysDisplay($acct->GetPage(), $bChinese))		$str .= ' - '.$strSeries;
	return $str;
}

function GetMetaDescription($bChinese)
{
	$str = GetTitle($bChinese);
	$str .= $bChinese ? '。2014年12月12号由深圳远东妇儿科医院馨月馆月子中心的专业摄影师拍摄和处理。大家看看值多少钱，我反正觉得超级不值！' : '. Taken by professional photographers from Shenzhen Far East International Medical Center.';
	return CheckMetaDescription($str);
}

   	$acct = new TitleAccount();
?>
