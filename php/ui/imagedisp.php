<?php
define('IMAGE_PATH', '/woody/blog/photo/');

function _breakImgElement($strFileName, $bChinese, $strTextCn, $strTextUs = '')
{
	return GetBreakElement().GetImgElement(IMAGE_PATH.$strFileName, ($bChinese ? $strTextCn : $strTextUs));
}

// chisquaredtest.jpg
function ImgChiSquared($bChinese = true)
{
	return _breakImgElement('chi2PValue.gif', $bChinese, 'Pearson卡方检验方程和曲线', "Pearson's Chi-squared Test equation and curve");
}

function ImgCramersRule($bChinese = true)
{
	return _breakImgElement('20190815.jpg', $bChinese, '用Cramer法则计算步骤', "Cramer's rule calculation steps");
}

function ImgLinearRegression($bChinese = true)
{
	return _breakImgElement('20190824.jpg', $bChinese, '线性回归计算步骤', 'Linear regression calculation steps');
}

function ImgRobloxDice($bChinese = true)
{
	return _breakImgElement('robloxdice.jpg', $bChinese, '罗布乐思4个骰子加14验证码', 'Roblox 4 dices adding to 14 captcha');
}

?>
