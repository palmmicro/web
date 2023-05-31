<?php
require_once('_stock.php');
require_once('_idgroup.php');
require_once('_editgroupform.php');
require_once('../../php/ui/referenceparagraph.php');
require_once('../../php/ui/ahparagraph.php');
require_once('../../php/ui/fundlistparagraph.php');
require_once('../../php/ui/fundestparagraph.php');
require_once('../../php/ui/imagedisp.php');

function in_array_ref($ref, $arRef)
{
	if ($ref)
	{
		$strSymbol = $ref->GetSymbol();
		foreach ($arRef as $ref)
		{
			if ($ref->GetSymbol() == $strSymbol)	return $ref;
		}
		return false;
	}
	return true;
}

function _echoStockGroupArray($arStock, $bAdmin)
{
    StockPrefetchArrayExtendedData($arStock);

    $arRef = array();
    $arTransactionRef = array();
    $arFund = array();
    $arAbRef = array();
    $arAhRef = array();
    $arAdrRef = array();
    $arFundPairRef = array();
    
    foreach ($arStock as $strSymbol)
    {
		$ref = StockGetReference($strSymbol);
        if ($ref->IsFundA())
        {
        	if (in_arrayQdiiMix($strSymbol))		$arFund[] = new HoldingsReference($strSymbol);
        	else
        	{
        		$arFund[] = StockGetFundReference($strSymbol);
        		if ($pair_ref = StockGetFundPairReference($strSymbol))		$arFundPairRef[] = $pair_ref;
        	}
       	}
    	else if ($pair_ref = StockGetFundPairReference($strSymbol))	$arFundPairRef[] = $pair_ref;
   		else
   		{
	    	list($ab_ref, $ah_ref, $adr_ref) = StockGetPairReferences($strSymbol);
    		if (in_array_ref($ab_ref, $arAbRef) == false)			$arAbRef[] = $ab_ref;
    		if (in_array_ref($ah_ref, $arAhRef) == false)			$arAhRef[] = $ah_ref;
    		if (in_array_ref($adr_ref, $arAdrRef) == false)		$arAdrRef[] = $adr_ref;
	    }

        $arRef[] = $ref;
        if ($ref->IsTradable())	$arTransactionRef[] = $ref;
    }
    
    EchoReferenceParagraph($arRef, $bAdmin);
    if (count($arFund) > 0)     			EchoFundArrayEstParagraph($arFund);
    if (count($arAbRef) > 0)				EchoAbParagraph($arAbRef);
    if (count($arAhRef) > 0)				EchoAhParagraph($arAhRef);
    if (count($arAdrRef) > 0)			EchoAdrhParagraph($arAdrRef);
    if (count($arFundPairRef) > 0)		EchoFundListParagraph($arFundPairRef);
    
    return $arTransactionRef;
}

function _getMetaDescriptionStr($strPage)
{
	$ar = array('abcompare' => AB_COMPARE_DISPLAY.'工具，按A/B价格比和B/A价格比排序。B股的正式名称是人民币特种股票，以外币认购和买卖，在中国上海和深圳证券交易所上市交易。',
				  'adrhcompare' => ADRH_COMPARE_DISPLAY.'工具，按ADR/H价格比和H/ADR价格比排序。这里H股泛指香港上市的所有企业，ADR也不限于传统意义，同时包括了二次回港上市美股。',
				  'ahcompare' => AH_COMPARE_DISPLAY.'工具，按A/H价格比和H/A价格比排序。H股开始是指获中国证监会批核到香港上市的国有企业，也称国企股，现在已经扩大到两地上市私企。',
				  'chinaindex' => CHINA_INDEX_DISPLAY.'基金工具, 计算基金净值, 同时分析比较各种套利对冲方案. 包括美股ASHR和多家国内基金公司的A股沪深300指数基金的配对交易等.',
				  'chinainternet' => '跟踪几个不同中证海外中国互联网指数的中概互联基金们在2021年初疯狂见顶后几个月时间一路狂泻都跌成了'.CHINAINTERNET_GROUP_DISPLAY.'，也因此跌出了QDII基金有史以来最为壮观的流动性。',
				  'commodity' => COMMODITY_GROUP_DISPLAY.'基金的净值估算, 目前包括大致对应跟踪GSG的信诚商品(SZ165513)和银华通胀(SZ161815). 跟踪大宗商品期货的基金都有因为期货升水带来的损耗, 不建议长期持有.',
				  'fundlist' => '各个估值页面中用到的基金和指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况. 有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.',
				  'goldsilver' => '当A股大跌的时候, 完全不相关的'.GOLD_SILVER_DISPLAY.'基金也经常会跟着跌, 这样会产生套利机会. 这里计算各种金银基金的净值, 同时分析比较各种套利对冲方案.',
				  'hangseng' => HANGSENG_GROUP_DISPLAY.'基金的净值估算。使用恒生指数【^HSI】计算官方估值和参考估值、使用恒生指数期货【hf_HSI】提供港股不开盘期间的实时估值。',
				  'hshares' => '港交所在2017年后玩弄文字游戏把H股国企指数改成'.HSHARES_GROUP_DISPLAY.'，大量加入非国有企业成分股，就是为了吸引迷信鹅厂的国内韭菜跨过香江去夺取港股定价权！',
				  'hstech' => '厌倦了港交所加印花税的贪婪，本来没想跟踪'.HSTECH_GROUP_DISPLAY.'基金的净值。不过在无意中发现了KTEC后，觉得还是应该补上，为日后可能的跨市场套利机会做好准备。',
				  'oilfund' => '跟踪'.OIL_GROUP_DISPLAY.'期货的基金有升水损耗，不建议长期持有。跨市场套利时，不要赌几个小时后A股QDII基金折价溢价转折点，只做连续折价或者连续溢价套利。',
				  'qdii' => QDII_DISPLAY.'官方估值用来验证计算方式的准确性。以参考估值为准，折价不申购、溢价不赎回。上涨赚溢价、下跌赚净值，不要怂，就是干！',
				  'qdiieu' => '加了'.QDII_JP_DISPLAY.'后，我意识到华安基金的德国和法国指数ETF可以也用同样的模式估值，忍不住再加上这个'.QDII_EU_DISPLAY.'页面，看看能不能解决之前一直估值不准的问题。',
				  'qdiihk' => '把'.QDII_HK_DISPLAY.'从其它QDII页面分出来，不光能够优化网站和代码结构，还能更好的体验股市三大幻觉：A股要涨、美股见顶、港股便宜！',
				  'qdiijp' => '四个跟踪日经225指数的'.QDII_JP_DISPLAY.'上市好几年来一直不愠不火，直到最近有人趁巴菲特光环和易方达因为'.CHINAINTERNET_GROUP_DISPLAY.'缺QDII额度的机会拉场内溢价，让我觉得不能再观望下去了！',
				  'qdiimix' => '采用跟踪成分股变化的方式对同时有美股、港股和A股持仓的'.CHINAINTERNET_GROUP_DISPLAY.'等'.QDII_MIX_DISPLAY.'基金进行净值估算，这样参考估值可以反应白天港股和A股波动对净值的影响。',
				  'qqqfund' => QQQ_GROUP_DISPLAY.'基金的净值估算。使用纳斯达克100指数^NDX计算官方估值和参考估值，芝商所纳斯达克期货NQ计算实时估值，QQQ仅用于参考。',
				  'spyfund' => SPY_GROUP_DISPLAY.'基金的净值估算。使用标普500指数^GSPC计算官方估值和参考估值，芝商所标普500期货ES计算实时估值，SPY仅用于参考。',
				  );
    return $ar[$strPage];
}

function _getSimilarLinks($strPage)
{
    switch ($strPage)
    {
    case 'adrhcompare':
    	$str = GetExternalLink(GetAastocksAdrUrl(), '阿思達克ADR').' '.GetExternalLink(GetAastocksSecondListingUrl(), '阿思達克二次回港上市').' '.GetExternalLink('https://www.gswarrants.com.hk/tc/tools/adr', '高盛');
        break;
  
    case 'ahcompare':
    	$str = GetExternalLink(GetSinaChinaStockListUrl('aplush'), '新浪').' '.GetExternalLink(GetAastocksAhUrl(), '阿思達克').' '.GetExternalLink('http://data.10jqka.com.cn/market/ahgbj/', '同花顺');
        break;
        
    default:
    	return false;
    }
    return '<br />类似软件：'.$str;
}

function _getOldBugs($strPage)
{
    switch ($strPage)
    {
    case 'adrhcompare':
    case 'ahcompare':
    	$str = '2018年9月3日星期一，00386分红除权，导致AH和ADRH对比不准。SNP的分红除权在9月5日，而SH600028的分红除权在9月12日。';
        break;
        
    default:
    	return false;
    }
    return '<br />已知问题：'.$str;
}

function _getGroupImageLink($strPage)
{
    switch ($strPage)
    {
    case 'chinainternet':
    	return ImgHuangRong();
    	
    case 'hangseng':
    case 'hshares':
    case 'hstech':
    	return GetWoodyImgQuote('luodayou.jpg', '罗大佑弹唱流到香江去看一看');
    	
    case 'oilfund':
    	return ImgPanicFree();
    	
    case 'qdii':
    	return ImgWinMan();

    case 'qdiieu':
    	return ImgQueen();

    case 'qdiihk':
    	return ImgRonin();
    	
	case 'qdiimix':
    	return ImgRuLai();

	case 'qdiijp':
    	return ImgSantaFe();

    case 'qqqfund':
    	return ImgLikeDog();
    	
    case 'spyfund':
    	return ImgBuffettCards();
    }
    return false;
}

function EchoAll()
{
	global $acct;
	
	$bAdmin = $acct->IsAdmin();
	$strPage = $acct->GetPage();
    if ($strPage == 'mystockgroup')
    {
        if ($strGroupId = $acct->EchoStockGroup())
        {
        	$arStock = SqlGetStocksArray($strGroupId);
        	if (count($arStock) > 0)
        	{
        		$arTransactionRef = _echoStockGroupArray($arStock, $bAdmin);
        		$group = new MyStockGroup($strGroupId, $arTransactionRef);
        		if ($acct->EchoStockTransaction($group))		$acct->EchoMoneyParagraph($group, new CnyReference('USCNY'), new CnyReference('HKCNY'));
        	}
        }
        else
        {
        	EchoStockGroupParagraph($acct);
        	StockEditGroupForm($acct, DISP_NEW_CN);
        }
    }
    else
    {
        _echoStockGroupArray(StockGetArraySymbol(GetCategoryArray($strPage)), $bAdmin);
        
    	$str = _getMetaDescriptionStr($strPage);
		if ($strLinks = _getSimilarLinks($strPage))		$str .= $strLinks;
		if ($strBugs = _getOldBugs($strPage))			$str .= $strBugs;
        if ($strImage = _getGroupImageLink($strPage))	$str .= $strImage;
        EchoParagraph($str);
    }
    $acct->EchoLinks($strPage);
}

function GetMetaDescription()
{
	global $acct;
	
	$strPage = $acct->GetPage();
    if ($strPage == 'mystockgroup')
    {
   		$str = $acct->GetWhoseGroupDisplay();
        $str .= '股票分组管理页面. 提供现有股票分组列表和编辑删除链接, 以及新增加股票分组的输入控件. 跟php/_editgroupform.php和php/_submitgroup.php配合使用.';
    }
    else	$str = _getMetaDescriptionStr($strPage);
    return CheckMetaDescription($str);
}

function _getTitleStr($strPage)
{
	$strTool = '基金净值计算工具';
	$ar = array('abcompare' => AB_COMPARE_DISPLAY,
				  'adrhcompare' => ADRH_COMPARE_DISPLAY,
			  	  'ahcompare' => AH_COMPARE_DISPLAY,
			  	  'chinaindex' => CHINA_INDEX_DISPLAY.$strTool,
			  	  'chinainternet' => CHINAINTERNET_GROUP_DISPLAY.$strTool,
			  	  'commodity' => COMMODITY_GROUP_DISPLAY.$strTool,
			  	  'fundlist' => FUND_LIST_DISPLAY,
			  	  'goldsilver' => GOLD_SILVER_DISPLAY.$strTool,
			  	  'hangseng' => HANGSENG_GROUP_DISPLAY.$strTool,
			  	  'hshares' => HSHARES_GROUP_DISPLAY.$strTool,
			  	  'hstech' => HSTECH_GROUP_DISPLAY.$strTool,
			  	  'oilfund'	=> OIL_GROUP_DISPLAY.$strTool,
			  	  'qdii' => QDII_DISPLAY,
			  	  'qdiieu' => QDII_EU_DISPLAY.$strTool,
			  	  'qdiihk' => QDII_HK_DISPLAY.$strTool,
			  	  'qdiijp' => QDII_JP_DISPLAY.$strTool,
			  	  'qdiimix' => QDII_MIX_DISPLAY.$strTool,
			  	  'qqqfund'	=> QQQ_GROUP_DISPLAY.$strTool,
			  	  'spyfund'	=> SPY_GROUP_DISPLAY.$strTool,
			  	  );
	return $ar[$strPage];
}

function GetTitle()
{
	global $acct;
	
	$strPage = $acct->GetPage();
	return ($strPage == 'mystockgroup')  ? $acct->GetWhoseGroupDisplay().STOCK_GROUP_DISPLAY : _getTitleStr($strPage);
}

	$acct = new GroupIdAccount();
	if ($acct->GetPage() == 'mystockgroup')
	{
		if ($acct->GetMemberId() == false)
		{
			if ($acct->GetQuery() == false)		$acct->Auth();
		}
	}

?>

