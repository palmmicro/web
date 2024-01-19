<?php
define('PATH_20141211', '/woody/image/20141211/');

function _getPhotoParagraph($strFileName, $strTextCn, $strTextUs = '', $bChinese = true, $strExtra = '')
{
	return GetPhotoParagraph(PATH_20141211.$strFileName, $strTextCn, $strTextUs, $bChinese, $strExtra);
}

function PhotoMiaRedAll($bChinese = true)
{
	return _getPhotoParagraph('4.jpg', '圣诞小红帽系列', 'Mia in Christmas red hat', $bChinese);
}

function PhotoMiaBlueAll($bChinese = true)
{
	return _getPhotoParagraph('7.jpg', '蓝色系列', 'Mia in blue', $bChinese);
}

function PhotoMiaBlue($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5347.JPG', '白衣蓝帽', 'Mia in white dress and blue hat', $bChinese, $strExtra);
}

function PhotoMiaBlueHalf($bChinese = true)
{
	return _getPhotoParagraph('IMG_5351.JPG', '白衣蓝帽半身照', 'Mia in white dress and blue hat, half view.', $bChinese);
}

function PhotoMiaBlueFull($bChinese = true)
{
	return _getPhotoParagraph('IMG_5358.JPG', '蓝帽全身照', 'Mia in blue hat, full view.', $bChinese);
}

function PhotoMiaBlueYawning($bChinese = true)
{
	return _getPhotoParagraph('IMG_5360.JPG', '打哈欠的蓝帽全身照', 'Mia in blue hat, yawning.', $bChinese);
}

function PhotoMiaBluePuppy($bChinese = true)
{
	return _getPhotoParagraph('IMG_5371.JPG', '带来福的蓝帽全身照', 'Mia in blue hat, with puppy.', $bChinese);
}

function PhotoMiaBlueGazing($bChinese = true)
{
	return _getPhotoParagraph('IMG_5372.JPG', '凝望的蓝帽全身照', 'Mia in blue hat, gazing.', $bChinese);
}

function PhotoMiaRedLost($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5375.JPG', '来福丢了', 'Where is my puppy?', $bChinese);
}

function PhotoMiaRedHalf($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5378.JPG', '圣诞小红帽和来福半身照', 'Mia in Christmas red hat with puppy, half view.', $bChinese);
}

function PhotoMiaRed($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5382.JPG', '圣诞小红帽和来福', 'Mia in Christmas red hat with puppy', $bChinese, $strExtra);
}

function PhotoMiaRedWondering($bChinese = true, $strExtra = '')
{
	return _getPhotoParagraph('IMG_5386.JPG', '疑惑中的圣诞小红帽和来福', 'Mia in Christmas red hat with puppy, wondering.', $bChinese);
}


?>
