<?php

function GetImgQuote($strPathName, $strText = '', $bChinese = true)
{
   	$strNewLine = GetBreakElement();
	return $strNewLine.GetImgElement($strPathName, $strText).$strNewLine.GetQuoteElement($strText);
}

function GetImgAutoSuffix()
{
	return '__.jpg';
}

function ImgAutoQuote($strPathName, $strText = '', $bChinese = true)
{
	$iDisplayHeight = LayoutGetDisplayHeight();
	$iFit = LayoutGetDisplayWidth();
	
	$imgOrg = imagecreatefromjpeg(UrlModifyRootFileName($strPathName));
	$iWidth = imagesx($imgOrg);
	$iHeight = imagesy($imgOrg);
//	DebugString($strPathName.':'.strval($iWidth).'x'.strval($iHeight), true);
	
	$iFitHeight = intval($iFit * $iHeight / $iWidth);
	if ($iFitHeight > $iDisplayHeight)
	{
		$iFit = DEFAULT_WIDTH;
		$iFitHeight = intval($iFit * $iHeight / $iWidth);
		if ($iFitHeight < $iDisplayHeight)
		{
			$iFitHeight = $iDisplayHeight;
			$iFit = intval($iWidth * $iFitHeight / $iHeight);
		}
	}
	
	if ($iWidth > $iFit)
	{
		$strFit = strval($iFit);
		$strNewName = substr($strPathName, 0, strlen($strPathName) - 4).'x'.$strFit.GetImgAutoSuffix();
		$strNewRootName = UrlModifyRootFileName($strNewName); 
		if (!file_exists($strNewRootName))
//		if (!file_exists($strNewName))
		{
			DebugString('Converting '.$strNewName);
			$imgNew = imagecreatetruecolor($iFit, $iFitHeight);
			imagecopyresampled($imgNew, $imgOrg, 0, 0, 0, 0, $iFit, $iFitHeight, $iWidth, $iHeight);
			imagejpeg($imgNew, $strNewRootName);
			imagedestroy($imgNew);
		}
		
		$strQuote = GetImgQuote($strNewName, $strText.' '.$strFit.'x'.strval($iFitHeight), $bChinese).' '.GetExternalLink($strPathName, $bChinese ? '原图' : 'Original');
	}
	else
	{
		$strQuote = GetImgQuote($strPathName, $strText, $bChinese);
	}
	imagedestroy($imgOrg);
	
	return $strQuote;
}

function ImgWoodyHomepage($bChinese = true)
{
	return GetImgQuote('/woody/myphoto/2016/becool.jpg', ($bChinese ? '天生会摆酷' : 'Be cool'), $bChinese);
}

function ImgWoodyBike($bChinese = true)
{
	return GetImgQuote('/woody/image/mybike.jpg', ($bChinese ? '2007年早春，我的宝马。' : 'Early spring of 2007, my precious bike.'), $bChinese);
}

function ImgHalfMoonBay($bChinese = true)
{
	return GetImgQuote('/woody/groupphoto/company/20070920.jpg', ($bChinese ? '2007年9月20日王老板王老板、唐丽和我在加州半月湾。' : 'Sep 20, 2007 Dr Wang, Tang Li and me in Half Moon Bay.'), $bChinese);
}

define('PATH_BLOG_PHOTO', '/woody/blog/photo/');
function GetWoodyImgQuote($strFileName, $strText, $strTextUs = '', $bChinese = true)
{
	return GetImgQuote(PATH_BLOG_PHOTO.$strFileName, ($bChinese ? $strText : $strTextUs), $bChinese);
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

function ImgTianHeng()
{
	return GetWoodyImgQuote('tianheng.jpg', '田横五百壮士');
}

function ImgBelieveMe($bChinese = true)
{
	return ImgAutoQuote(PATH_BLOG_PHOTO.'believe.jpg', ($bChinese ? '至于你信不信，我反正信了。' : 'You believe it or not, I believe it anyway.'), $bChinese);
}

function ImgAlwaysWin()
{
	return ImgAutoQuote(PATH_BLOG_PHOTO.'linqingxia.jpg', '东方不败林青霞');
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
		return GetWoodyImgQuote('easything.jpg', '成年人的生活中没有容易二字');
	}
	return '';
}

function ImgStockGroup($strPage)
{
    switch ($strPage)
    {
    case 'biotech':
		return ImgAlwaysWin();
    	
    case 'chinainternet':
    	return GetWoodyImgQuote('huangrong.jpg', '依稀往梦似曾见，心内波澜现。');
    	
    case 'hangseng':
    	return ImgAutoQuote(PATH_BLOG_PHOTO.'luody.jpg', '小河弯弯向南流，流到香江去看一看。');

    case 'hshares':
    	return ImgAutoQuote(PATH_BLOG_PHOTO.'ChowYunFat.jpg', '英雄本色');
    	
    case 'hstech':
    	return GetWoodyImgQuote('hardlife.jpg', '人生永远都在艰难模式');

    case 'lof':
//    	return GetWoodyImgQuote('nvda.png', '老黄路边KTV');
		return ImgAutoQuote(PATH_BLOG_PHOTO.'freefood.jpg', '又要到饭了兄弟们');
    	
    case 'mscius50':
    	return ImgBelieveMe();
    	
    case 'oilfund':
    	return GetWoodyImgQuote('dashidai.jpg', '不要怕，是技术性调整，不要怕。');
    	
    case 'qdii':
    	return GetWoodyImgQuote('gan.jpg', '赢了会所嫩模，输了下海挖沙！');

    case 'qdiieu':
    	return GetWoodyImgQuote('queen.jpg', '命运赠送的礼物都早已暗中标好了价格');

    case 'qdiihk':
   		return GetWoodyImgQuote('ronin.jpg', '女士，如果一个地方我不知道如何走出去，就绝不会走进去。');	// Lady, I never walk into a place I don't know how to walk out of.

	case 'qdiijp':
		return ImgSantaFe();
		
	case 'qdiimix':
		return ImgAutoQuote(PATH_BLOG_PHOTO.'rulai.jpg', '年轻人，我这儿有本秘籍。');

    case 'qqqfund':
    	return ImgLikeDog();
    	
    case 'spyfund':
    	return ImgBuffettCards();
    }
    return '';
}

/*
<video width="720" height="1280" controls poster="../blog/photo/20200915.jpg">
	<source src="../blog/photo/sz161130.mp4" type="video/mp4">
	你的浏览器不支持video标签
</video>
*/

function GetVideoControl($strPathName, $strText = '', $bChinese = true)
{
	$strPosterFile = substr($strPathName, 0, strlen($strPathName) - 4).'.jpg';
	$strPosterRootName = UrlModifyRootFileName($strPosterFile); 
	if (file_exists($strPosterRootName))
	{
		$imageInfo = getimagesize($strPosterRootName);
		if ($imageInfo !== false) 
		{
			$iWidth = $imageInfo[0]; // Width is at index 0
			$iHeight = $imageInfo[1]; // Height is at index 1
			$strNewLine = GetBreakElement();
			if (LayoutGetDisplayWidth() < $iWidth)
			{
				$str = GetFileLink($strPathName);
				$str .= ImgAutoQuote($strPosterFile, $strText, $bChinese);
			}
			else
			{
				$str = GetHtmlElement('<source src="'.$strPathName.'" type="video/mp4">', 'video', array('width' => GetDoubleQuotes(strval($iWidth)), 'height' => GetDoubleQuotes(strval($iHeight)), 'controls' => false, 'poster' => GetDoubleQuotes($strPosterFile)));   
				$str .= $strNewLine.GetQuoteElement($strText);
			}
			return $strNewLine.$str;
		}
	}
	return '';
}

function VidAboutSZ161130($bChinese = true)
{
	return GetVideoControl(PATH_BLOG_PHOTO.'sz161130.mp4', ($bChinese ? '关于SZ161130的直播视频回放' : 'SZ161130 live broadcast video playback'), $bChinese);
}

?>
