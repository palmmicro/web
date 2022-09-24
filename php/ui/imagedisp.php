<?php
define('IMAGE_PATH', '/woody/blog/photo/');

function QuoteImgElement($strFileName, $strTextCn, $strTextUs = '', $bChinese = true)
{
   	$strNewLine = GetBreakElement();
   	$strText = $bChinese ? $strTextCn : $strTextUs;
	return $strNewLine.GetImgElement(IMAGE_PATH.$strFileName, $strText).$strNewLine.GetQuoteElement($strText);
}

function ImgBuffettCards($bChinese = true)
{
	return QuoteImgElement('buffettplaycards.jpg', '巴菲特和盖茨一起打桥牌');
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

function ImgGreatDynasty($bChinese = true)
{
	return QuoteImgElement('daqingwangle.jpg', '拉倒吧，联的大清都亡了！');
}

function ImgHuangRong($bChinese = true)
{
   	return QuoteImgElement('huangrong.jpg', '依稀往梦似曾见，心内波澜现。');
}

function ImgLikeDog($bChinese = true)
{
	return QuoteImgElement('dog.jpg', '咦，那个人看上去好像一条狗！');
}

function ImgLinearRegression($bChinese = true)
{
	return QuoteImgElement('20190824.jpg', '线性回归计算步骤', 'Linear regression calculation steps', $bChinese);
}

function ImgMrFox($bChinese = true)
{
   	return QuoteImgElement('fantasticmrfox.jpg', '了不起的狐狸爸爸会干很多事情，但是刺猬才会干大事。', 'A fox knows many things, but a hedgehog knows one big thing.', $bChinese);
}

function ImgPanicFree($bChinese = true)
{
	return QuoteImgElement('dashidai.jpg', '不要怕，是技术性调整，不要怕。');
}

function ImgRobloxDice($bChinese = true)
{
	return QuoteImgElement('robloxdice.jpg', '罗布乐思4个骰子加14验证码', 'Roblox 4 dices adding to 14 captcha', $bChinese);
}

function ImgRonin($bChinese = true)
{
   	return QuoteImgElement('ronin.jpg', '女士，如果一个地方我不知道如何走出去，就绝不会走进去。', 'Lady, I never walk into a place I don\'t know how to walk out of.', $bChinese);
}

function ImgRuLai($bChinese = true)
{
   	return QuoteImgElement('rulai.jpeg', '年轻人，我这儿有本秘籍。');
}

function ImgWinMan($bChinese = true)
{
	return QuoteImgElement('gan.jpg', '赢了会所嫩模，输了下海挖沙！');
}

?>
