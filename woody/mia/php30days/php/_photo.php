<?php

function PhotoMiaBlueAll($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/7.jpg', '蓝色系列', 'Mia in blue', $bChinese);
}

function PhotoMiaBlue($bChinese = true, $strExtra = '')
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5347.JPG', '白衣蓝帽', 'Mia in white dress and blue hat', $bChinese, $strExtra);
}

function PhotoMiaBlueHalf($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5351.JPG', '白衣蓝帽半身照', 'Mia in white dress and blue hat, half view.', $bChinese);
}

function PhotoMiaBlueFull($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5358.JPG', '蓝帽全身照', 'Mia in blue hat, full view.', $bChinese);
}

function PhotoMiaBlueYawning($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5360.JPG', '打哈欠的蓝帽全身照', 'Mia in blue hat, yawning.', $bChinese);
}

function PhotoMiaBluePuppy($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5371.JPG', '带来福的蓝帽全身照', 'Mia in blue hat, with puppy.', $bChinese);
}

function PhotoMiaBlueGazing($bChinese = true)
{
	return GetPhotoParagraph('/woody/image/20141211/IMG_5372.JPG', '凝望的蓝帽全身照', 'Mia in blue hat, gazing.', $bChinese);
}

?>
