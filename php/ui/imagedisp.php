<?php

function GetImgQuote($strPathName, $strTextCn, $strTextUs = '', $bChinese = true)
{
   	$strNewLine = GetBreakElement();
   	$strText = $bChinese ? $strTextCn : $strTextUs;
	return $strNewLine.GetImgElement($strPathName, $strText).$strNewLine.GetQuoteElement($strText);
}

function ImgPalmmicroWeixin($bChinese = true)
{
	return GetImgQuote('/woody/image/wx.jpg', 'Palmmicro微信公众号sz162411小狐狸二维码', 'Palmmicro weixin public account sz162411 small fox QR code', $bChinese);
}

function GetWoodyImgQuote($strFileName, $strText)
{
	return GetImgQuote('/woody/blog/photo/'.$strFileName, $strText);
}

function ImgBuffettCards()
{
	return GetWoodyImgQuote('buffettplaycards.jpg', '巴菲特和盖茨一起打桥牌');
}

// chisquaredtest.jpg
function ImgChiSquared()
{
	return GetWoodyImgQuote('chi2PValue.gif', 'Pearson卡方检验方程和曲线');
}

function ImgCramersRule()
{
	return GetWoodyImgQuote('20190815.jpg', '用Cramer法则计算步骤');
}

function ImgEasyThing()
{
   	return GetWoodyImgQuote('easything.jpeg', '成年人的生活中没有容易二字');
}

function ImgGreatDynasty()
{
	return GetWoodyImgQuote('daqingwangle.jpg', '拉倒吧，联的大清都亡了！');
}

function ImgHuangRong()
{
   	return GetWoodyImgQuote('huangrong.jpg', '依稀往梦似曾见，心内波澜现。');
}

function ImgJensenHuang()
{
   	return GetWoodyImgQuote('nvda.png', '老黄路边KTV');
}

function ImgLikeDog()
{
	return GetWoodyImgQuote('dog.jpg', '咦，那个人看上去好像一条狗！');
}

function ImgLinearRegression()
{
	return GetWoodyImgQuote('20190824.jpg', '线性回归计算步骤');
}

// A fox knows many things, but a hedgehog knows one big thing.
function ImgMrFox()
{
   	return GetWoodyImgQuote('fantasticmrfox.jpg', '了不起的狐狸爸爸会干很多事情，但是刺猬才会干大事。');
}

function ImgPanicFree()
{
	return GetWoodyImgQuote('dashidai.jpg', '不要怕，是技术性调整，不要怕。');
}

function ImgQueen()
{
   	return GetWoodyImgQuote('queen.jpg', '命运赠送的礼物都早已暗中标好了价格');
}

function ImgRobloxDice()
{
	return GetWoodyImgQuote('robloxdice.jpg', '罗布乐思4个骰子加14验证码');
}

// Lady, I never walk into a place I don't know how to walk out of.
function ImgRonin()
{
   	return GetWoodyImgQuote('ronin.jpg', '女士，如果一个地方我不知道如何走出去，就绝不会走进去。');
}

function ImgRuLai()
{
   	return GetWoodyImgQuote('rulai.jpeg', '年轻人，我这儿有本秘籍。');
}

function ImgSantaFe()
{
	return GetWoodyImgQuote('santafe.jpg', '宫泽理惠Santa Fe写真');
}

function ImgTianHeng()
{
	return GetWoodyImgQuote('tianheng.jpg', '田横五百壮士');
}

function ImgWinMan()
{
	return GetWoodyImgQuote('gan.jpg', '赢了会所嫩模，输了下海挖沙！');
}

?>
