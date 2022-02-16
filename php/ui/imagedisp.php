<?php
define('IMAGE_PATH', '/woody/blog/photo/');

function ImgRobloxDice($bChinese = true)
{
	return GetBreakElement().GetImgElement(IMAGE_PATH.'robloxdice.jpg', ($bChinese ? '罗布乐思4个骰子加14验证码' : 'Roblox 4 dices adding to 14 captcha'));
}

?>
