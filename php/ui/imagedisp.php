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

function ImgWoodyHomepage($bChinese = true)
{
	return GetImgQuote('/woody/image/iwantyou.jpg', '天生会摆酷', 'Be cool', $bChinese);
}

function ImgWoodyBike($bChinese = true)
{
	return GetImgQuote('/woody/image/mybike.jpg', '2007年早春，我的宝马。', 'Early spring of 2007, my precious bike.', $bChinese);
}

function ImgWoody20060701($bChinese = true)
{
	return GetImgQuote('/woody/myphoto/2006/baihuashan.jpg', '2006年7月1日绿野百花山', 'July 1, 2006. Baihua Mountain.', $bChinese);
}

function ImgWoody20070920($bChinese = true)
{
	return GetImgQuote('/woody/groupphoto/company/20070920.jpg', '2007年9月20日王老板在加州半月湾', 'Sep 20, 2007. Chi-Shin Wang in Half Moon Bay.', $bChinese);
}

function GetWoodyImgQuote($strFileName, $strText, $strTextUs = '', $bChinese = true)
{
	return GetImgQuote('/woody/blog/photo/'.$strFileName, $strText, $strTextUs, $bChinese);
}

function ImgBuffettCards()
{
	return GetWoodyImgQuote('buffettplaycards.jpg', '巴菲特和盖茨一起打桥牌');
}

function ImgCompleteLenna($bChinese = true)
{
	return GetWoodyImgQuote('lenna.jpg', '经典测试图像Lenna部分原始图片', 'Part of the complete Lenna story', $bChinese);
}

function ImgGreatDynasty()
{
	return GetWoodyImgQuote('daqingwangle.jpg', '拉倒吧，联的大清都亡了！');
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

function ImgPhpBest($bChinese = true)
{
	return GetWoodyImgQuote('phpisbest.jpg', 'PHP是世界上最好的编程语言！', 'PHP is the best programming language in the world!', $bChinese);
}

function ImgPortfolio20141016($bChinese = true)
{
	return GetWoodyImgQuote('20141016.jpg', '2014年10月16日A股持仓截屏', 'Screen shot of my Chinese A stock portfolio as of Oct 16 2014', $bChinese);
}

function ImgSantaFe($bChinese = true)
{
	return GetWoodyImgQuote('santafe.jpg', '1991年宫泽理惠Santa Fe写真', '1991 Rie Miyazawa Santa Fe', $bChinese);
}

function ImgSapphireMermaid($bChinese = true)
{
	return GetWoodyImgQuote('mermaid.jpg', '圣地亚哥海洋世界的美人鱼', 'Mermaid and Sapphire in SeaWorld San Diego.', $bChinese);
}

function ImgSapphireSolitaire($bChinese = true)
{
	return GetWoodyImgQuote('solitaire.jpg', '加州乐高积木公园独自玩耍', 'Solitaire Sapphire in LEGOLAND CALIFORNIA.', $bChinese);
}

function ImgWorriedWoody($bChinese = true)
{
	return GetWoodyImgQuote('20141204.jpg', '我们两个都有点发愁', 'Woody and Sapphire Lin are both worried!', $bChinese);
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

    case 'dicecaptcha':
    	return GetWoodyImgQuote('robloxdice.jpg', '罗布乐思4个骰子加14验证码');
    	
	case 'linearregression':
		return GetWoodyImgQuote('20190824.jpg', ACCOUNT_TOOL_LINEAR_CN.'计算步骤');

	case 'primenumber':
		return GetWoodyImgQuote('primenumber.jpg', '激励我写'.ACCOUNT_TOOL_PRIME_CN.'工具的图片');

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
    	return GetWoodyImgQuote('luodayou.jpg', '小河弯弯向南流，流到香江去看一看。');
    	
    case 'hstech':
    	return GetWoodyImgQuote('hardlife.jpg', '人生永远都在艰难模式');
    	
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
