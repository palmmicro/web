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

function ImgGreatDynasty()
{
	return GetWoodyImgQuote('daqingwangle.jpg', '拉倒吧，联的大清都亡了！');
}

function ImgJensenHuang()
{
   	return GetWoodyImgQuote('nvda.png', '老黄路边KTV');
}

function ImgLikeDog()
{
	return GetWoodyImgQuote('dog.jpg', '咦，那个人看上去好像一条狗！');
}

// A fox knows many things, but a hedgehog knows one big thing.
function ImgMrFox()
{
   	return GetWoodyImgQuote('fantasticmrfox.jpg', '了不起的狐狸爸爸会干很多事情，但是刺猬才会干大事。');
}

function ImgRobloxDice()
{
	return GetWoodyImgQuote('robloxdice.jpg', '罗布乐思4个骰子加14验证码');
}

function ImgSantaFe()
{
	return GetWoodyImgQuote('santafe.jpg', '宫泽理惠Santa Fe写真');
}

function ImgSapphireMermaid()
{
	return GetWoodyImgQuote('mermaid.jpg', 'Feb 3, 2018. Mermaid and Sapphire in SeaWorld San Diego.');
}

function ImgSapphireSolitaire()
{
	return GetWoodyImgQuote('solitaire.jpg', 'Jan 29, 2018. Solitaire Sapphire in LEGOLAND CALIFORNIA.');
}

function ImgTianHeng()
{
	return GetWoodyImgQuote('tianheng.jpg', '田横五百壮士');
}

function ImgAccountTool($strPage)
{
	switch ($strPage)
	{
	case 'benfordslaw':
		return GetWoodyImgQuote('benfordslaw.jpg', "Benford's Law equation");

	case 'chisquaredtest':
		return GetWoodyImgQuote('chi2PValue.gif', 'Pearson卡方检验方程和曲线');	// chisquaredtest.jpg
		
	case 'cramersrule':
		return GetWoodyImgQuote('20190815.jpg', '用Cramer法则计算步骤');

	case 'linearregression':
		return GetWoodyImgQuote('20190824.jpg', '线性回归计算步骤');

	case 'simpletest':
		return GetWoodyImgQuote('easything.jpeg', '成年人的生活中没有容易二字');
	}
	return '';
}

function ImgStockGroup($strPage)
{
    switch ($strPage)
    {
    case 'chinainternet':
    	return GetWoodyImgQuote('huangrong.jpg', '依稀往梦似曾见，心内波澜现。');
    	
    case 'hangseng':
    case 'hshares':
    case 'hstech':
    	return GetWoodyImgQuote('luodayou.jpg', '罗大佑弹唱流到香江去看一看');
    	
    case 'oilfund':
    	return GetWoodyImgQuote('dashidai.jpg', '不要怕，是技术性调整，不要怕。');
    	
    case 'qdii':
    	return GetWoodyImgQuote('gan.jpg', '赢了会所嫩模，输了下海挖沙！');

    case 'qdiieu':
    	return GetWoodyImgQuote('queen.jpg', '命运赠送的礼物都早已暗中标好了价格');

    case 'qdiihk':
   		return GetWoodyImgQuote('ronin.jpg', '女士，如果一个地方我不知道如何走出去，就绝不会走进去。');	// Lady, I never walk into a place I don't know how to walk out of.
    	
	case 'qdiimix':
		return GetWoodyImgQuote('rulai.jpeg', '年轻人，我这儿有本秘籍。');

	case 'qdiijp':
		return ImgSantaFe();

    case 'qqqfund':
    	return ImgLikeDog();
    	
    case 'spyfund':
    	return ImgBuffettCards();
    }
    return '';
}

?>
