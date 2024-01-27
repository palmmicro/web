<?php
define('PATH_20141211', '/woody/image/20141211/');
define('PATH_30DAYS', '/woody/mia/30days/');

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

function PhotoMiaYellowAll($bChinese = true)
{
	return _getPhotoParagraph('2.jpg', Get30DaysDisplay('yellow'), 'In yellow', $bChinese);
}

function PhotoMiaRedAll($bChinese = true)
{
	return _getPhotoParagraph('4.jpg', Get30DaysDisplay('hat'), 'In Christmas red hat', $bChinese);
}

function PhotoMiaCrownAll($bChinese = true)
{
	return _getPhotoParagraph('6.jpg', Get30DaysDisplay('crown'), 'In crown', $bChinese);
}

function PhotoMiaBlueAll($bChinese = true)
{
	return _getPhotoParagraph('7.jpg', Get30DaysDisplay('blue'), 'In blue', $bChinese);
}

function PhotoMiaLeopardAll($bChinese = true)
{
	return _getPhotoParagraph('9.jpg', Get30DaysDisplay('leopard'), 'In leopard', $bChinese);
}

function PhotoMiaLeopardSmile($bChinese = true)
{
	return _getPhotoParagraph('IMG_5208.JPG', '谁也不知道我在笑啥', 'Nobody knows why I am smiling', $bChinese);
}

function PhotoMiaLeopard($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5226.JPG', '豹纹装和来福', 'In leopard print, with puppy.', $bChinese, $strExtra);
}

function PhotoMiaLeopardTired($bChinese = true)
{
	return _getPhotoParagraph('IMG_5228.JPG', '拍照真是一件累人的事情，来福和我都困了。', 'Both puppy and I are sleepy and tired', $bChinese);
}

function PhotoMiaLeopardHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5233.JPG', '豹纹半身照', 'In leopard print, half view.', $bChinese);
}

function PhotoMiaLeopardPuppy($bChinese = true)
{
	return _getPhotoParagraph('IMG_5239.JPG', '跟来福合影，我们像不像？', 'Do I look like this puppy?', $bChinese);
}

function PhotoMiaLeopardClose($bChinese = true)
{
	return _getPhotoParagraph('IMG_5249.JPG', '来福靠太近了吧！', 'The puppy is too close!', $bChinese);
}

function PhotoMiaLeopardMom($bChinese = true)
{
	return _getPhotoParagraph('IMG_5273.JPG', '趴妈妈背上', "On mom's back", $bChinese);
}

function PhotoMiaYellowRight($bChinese = true)
{
	return _getPhotoParagraph('IMG_5276.JPG', '在右边也同样蠢！', 'It is stupid to put a flower on my right too!', $bChinese);
}

function PhotoMiaYellowProtesting($bChinese = true)
{
	return _getPhotoParagraph('IMG_5279.JPG', '我要抗议！', 'I am protesting now!', $bChinese);
}

function PhotoMiaYellowLeft($bChinese = true)
{
	return _getPhotoParagraph('IMG_5284.JPG', '在我左边放朵花是不是看上去很蠢？', "Isn't it stupid to put a flower on my left?", $bChinese);
}

function PhotoMiaYellowUnhappy($bChinese = true)
{
	return _getPhotoParagraph('IMG_5286.JPG', '我要哭了', 'I am going to cry now', $bChinese);
}

function PhotoMiaYellowConfused($bChinese = true)
{
	return _getPhotoParagraph('IMG_5289.JPG', '我迷糊了', 'I am confused', $bChinese);
}

function PhotoMiaYellowTired($bChinese = true)
{
	return _getPhotoParagraph('IMG_5290.JPG', '我累了', 'I am getting tired', $bChinese);
}

function PhotoMiaYellowFull($bChinese = true)
{
	return _getPhotoParagraph('IMG_5292.JPG', '开始数数...', 'Let me count it...', $bChinese);
}

function PhotoMiaYellowHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5294.JPG', '你们要拍多少张？', 'How many pictures are you going to take?', $bChinese);
}

function PhotoMiaYellow($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5295.JPG', '黄色毛衣和小花', 'In yellow knit with flower', $bChinese, $strExtra);
}

function PhotoMiaYellowBetter($bChinese = true)
{
	return _getPhotoParagraph('IMG_5302.JPG', '这样稍微好点', 'Ok, this is better.', $bChinese);
}

function PhotoMiaYellowTooMuch($bChinese = true)
{
	return _getPhotoParagraph('IMG_5308.JPG', '不过实在拍太多了！', 'But it is really too much!', $bChinese);
}

function PhotoMiaYellowNoFlower($bChinese = true)
{
	return _getPhotoParagraph('IMG_5317.JPG', '我不要花，我的来福呢？', 'I really hate the flower, where is my puppy?', $bChinese);
}

function PhotoMiaFeetInHand($bChinese = true)
{
	return _getPhotoParagraph('IMG_5319.JPG', '脚放妈妈手中', "Feet in mom's hands", $bChinese);
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

function PhotoMiaRedLost($bChinese = true)
{
	return _getPhotoParagraph('IMG_5375.JPG', '来福丢了', 'Where is my puppy?', $bChinese);
}

function PhotoMiaRedHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5378.JPG', '圣诞小红帽和来福半身照', 'In Christmas red hat with puppy, half view.', $bChinese);
}

function PhotoMiaRed($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5382.JPG', '圣诞小红帽和来福', 'In Christmas red hat with puppy', $bChinese, $strExtra);
}

function PhotoMiaRedWondering($bChinese = true)
{
	return _getPhotoParagraph('IMG_5386.JPG', '疑惑中的圣诞小红帽和来福', 'In Christmas red hat with puppy, wondering.', $bChinese);
}

function PhotoMiaCrownMom($bChinese = true)
{
	return _getPhotoParagraph('IMG_5394.JPG', '跟妈妈合影', 'In crown with mom', $bChinese);
}

function PhotoMiaCrownFull($bChinese = true)
{
	return _getPhotoParagraph('IMG_5399.JPG', '王冠全身照', 'In crown, full view', $bChinese);
}

function PhotoMiaCrownHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5400.JPG', '王冠半身照', 'In crown, half view', $bChinese);
}

function PhotoMiaCrownSad($bChinese = true)
{
	return _getPhotoParagraph('IMG_5403.JPG', '有点忧伤', 'A little sad', $bChinese);
}

function PhotoMiaCrown($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5405.JPG', '第一次认真思考人生', 'Thinking about life for the first time', $bChinese, $strExtra);
}

function PhotoMiaRedDot($bChinese = true)
{
	return _getPhotoParagraph('IMG_5887.JPG', '圣诞小红帽和红点衣', 'In Christmas red hat and red dot dress', $bChinese);
}

function PhotoMiaHandInHand($bChinese = true)
{
	return _getPhotoParagraph('IMG_5899.JPG', '手放爸爸妈妈手中', "Hand in mom and dad's hands", $bChinese);
}

?>
