<?php
define('IMAGE_PATH', '/woody/blog/photo/');

function QuoteImgElement($strFileName, $strTextCn, $strTextUs = '', $bChinese = true)
{
   	$strNewLine = GetBreakElement();
   	$strText = $bChinese ? $strTextCn : $strTextUs;
	return $strNewLine.GetImgElement(IMAGE_PATH.$strFileName, $strText).$strNewLine.GetQuoteElement($strText);
}

// chisquaredtest.jpg
function ImgChiSquared($bChinese = true)
{
	return QuoteImgElement('chi2PValue.gif', 'Pearson卡方检验方程和曲线', "Pearson's Chi-squared Test equation and curve", $bChinese);
}

function ImgCramersRule($bChinese = true)
{
	return QuoteImgElement('20190815.jpg', '用Cramer法则计算步骤', "Cramer's rule calculation steps", $bChinese);
}

function ImgLinearRegression($bChinese = true)
{
	return QuoteImgElement('20190824.jpg', '线性回归计算步骤', 'Linear regression calculation steps', $bChinese);
}

function ImgRobloxDice($bChinese = true)
{
	return QuoteImgElement('robloxdice.jpg', '罗布乐思4个骰子加14验证码', 'Roblox 4 dices adding to 14 captcha', $bChinese);
}

function ImgWinMan($bChinese = true)
{
	return QuoteImgElement('gan.jpg', '赢了会所嫩模输了下海挖沙的老头');
}

?>
