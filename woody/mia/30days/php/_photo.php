<?php
define('PATH_20141211', '/woody/image/20141211/');
define('PATH_30DAYS', '/woody/mia/php30days/');

function Get30DaysMenuArray($bChinese)
{
    if ($bChinese)  $arName = array('blue' => '蓝色', 'hat' => '圣诞小红帽',    'crown' => '王冠',   'yellow' => '黄色',   'leopard' => '豹纹');
    else              $arName = array('blue' => 'Blue', 'hat' => 'Christmas Hat', 'crown' => 'Crown', 'yellow' => 'Yellow', 'leopard' => 'Leopard');
    return $arName;
}

function Get30DaysDisplay($strPage, $bChinese = true)
{
	$ar = Get30DaysMenuArray($bChinese);
    if (isset($ar[$strPage]))	return $ar[$strPage].($bChinese ? '系列' : ' Series');
    return false;
}

function Get30DaysLink($strPage, $bChinese = true)
{
    return GetPhpLink(PATH_30DAYS.$strPage, false, Get30DaysDisplay($strPage, $bChinese), $bChinese);
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

function _getPhotoParagraph($strFileName, $strTextCn, $strTextUs = '', $bChinese = true, $strExtra = '')
{
	return GetPhotoParagraph(PATH_20141211.$strFileName, ($bChinese ? $strTextCn : $strTextUs), $bChinese, $strExtra);
}

function PhotoMiaRedAll($bChinese = true)
{
	return _getPhotoParagraph('4.jpg', Get30DaysDisplay('hat'), 'In Christmas red hat', $bChinese);
}

function PhotoMiaBlueAll($bChinese = true)
{
	return _getPhotoParagraph('7.jpg', Get30DaysDisplay('blue'), 'In blue', $bChinese);
}

function PhotoMiaWhite($bChinese = true)
{
	return _getPhotoParagraph('IMG_5338.JPG', '白衣头花', 'In white dress with flower', $bChinese);
}

function PhotoMiaWhiteFull($bChinese = true)
{
	return _getPhotoParagraph('IMG_5342.JPG', '白衣头花全身照', 'In white dress with flower, full view.', $bChinese);
}

function PhotoMiaBlue($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5347.JPG', '白衣蓝帽', 'In white dress and blue hat', $bChinese, $strExtra);
}

function PhotoMiaBlueHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5351.JPG', '白衣蓝帽半身照', 'In white dress and blue hat, half view.', $bChinese);
}

function PhotoMiaBlueFull($bChinese = true)
{
	return _getPhotoParagraph('IMG_5358.JPG', '蓝帽全身照', 'In blue hat, full view.', $bChinese);
}

function PhotoMiaBlueYawning($bChinese = true)
{
	return _getPhotoParagraph('IMG_5360.JPG', '打哈欠的蓝帽全身照', 'In blue hat, yawning.', $bChinese);
}

function PhotoMiaBluePuppy($bChinese = true)
{
	return _getPhotoParagraph('IMG_5371.JPG', '带来福的蓝帽全身照', 'In blue hat, with puppy.', $bChinese);
}

function PhotoMiaBlueGazing($bChinese = true)
{
	return _getPhotoParagraph('IMG_5372.JPG', '凝望的蓝帽全身照', 'In blue hat, gazing.', $bChinese);
}

function PhotoMiaRedLost($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5375.JPG', '来福丢了', 'Where is my puppy?', $bChinese);
}

function PhotoMiaRedHalf($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5378.JPG', '圣诞小红帽和来福半身照', 'In Christmas red hat with puppy, half view.', $bChinese);
}

function PhotoMiaRed($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5382.JPG', '圣诞小红帽和来福', 'In Christmas red hat with puppy', $bChinese, $strExtra);
}

function PhotoMiaRedWondering($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5386.JPG', '疑惑中的圣诞小红帽和来福', 'In Christmas red hat with puppy, wondering.', $bChinese);
}


?>
