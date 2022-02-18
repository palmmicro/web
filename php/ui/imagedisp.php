<?php
define('IMAGE_PATH', '/woody/blog/photo/');

function BreakImgElement($strFileName, $strTextCn, $strTextUs = '', $bChinese = true)
{
	return GetBreakElement().GetImgElement(IMAGE_PATH.$strFileName, ($bChinese ? $strTextCn : $strTextUs));
}

// chisquaredtest.jpg
function ImgChiSquared($bChinese = true)
{
	return BreakImgElement('chi2PValue.gif', 'Pearson卡方检验方程和曲线', "Pearson's Chi-squared Test equation and curve", $bChinese);
}

function ImgCramersRule($bChinese = true)
{
	return BreakImgElement('20190815.jpg', '用Cramer法则计算步骤', "Cramer's rule calculation steps", $bChinese);
}

function ImgLinearRegression($bChinese = true)
{
	return BreakImgElement('20190824.jpg', '线性回归计算步骤', 'Linear regression calculation steps', $bChinese);
}

function ImgRobloxDice($bChinese = true)
{
	return BreakImgElement('robloxdice.jpg', '罗布乐思4个骰子加14验证码', 'Roblox 4 dices adding to 14 captcha', $bChinese);
}

?>
