<?php
require_once('_stock.php');
require_once('_editgroupform.php');
require_once('/php/stockhis.php');
//require_once('/php/stockgroup.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/fundestparagraph.php');

function _echoStockGroupParagraph($bChinese)
{
	EchoStockGroupParagraph($bChinese);	
    if ($bReadOnly == false)
    {
    	if ($bChinese)
    	{
    		$strSubmit = STOCK_GROUP_NEW_CN;
    	}
    	else
    	{
    		$strSubmit = STOCK_GROUP_NEW;
    	}
        StockEditGroupForm($strSubmit, $bChinese);
    }
}

function in_array_ref($strSymbol, $arRef)
{
	foreach ($arRef as $ref)
	{
		if ($ref->GetStockSymbol() == $strSymbol)
		{
			return $ref;
		}
	}
	return false;
}

function _prefetchStockGroupArray($arStock)
{
    StockPrefetchArrayData($arStock);
    GetChinaMoney();
}

function _echoStockGroupArray($arStock, $bChinese)
{
	_prefetchStockGroupArray($arStock);

    $arRef = array();
    $arTransactionRef = array();
    $arFund = array();
    $arHShareRef = array();
    $arHAdrRef = array();
    $arEtfRef = array();
    foreach ($arStock as $strSymbol)
    {
        $sym = new StockSymbol($strSymbol);
        if ($sym->IsFundA())
        {
        	$fund = StockGetFundReference($strSymbol);
        	$arFund[] = $fund;
	    	if ($ref = StockGetEtfReference($strSymbol))		$arEtfRef[] = $ref;
        	else												$ref = $fund->stock_ref; 
       	}
       	else
       	{
       		if ($ref_ar = StockGetHShareReference($sym))
       		{
       			list($ref, $hshare_ref) = $ref_ar;
       			if ($hshare_ref)
       			{
       				if ($hshare_ref->a_ref)
       				{
       					if (in_array_ref($hshare_ref->GetStockSymbol(), $arHShareRef) == false)		$arHShareRef[] = $hshare_ref;
       				}
       				if ($hshare_ref->adr_ref)
       				{
       					if (in_array_ref($hshare_ref->GetStockSymbol(), $arHAdrRef) == false)			$arHAdrRef[] = $hshare_ref;
       				}
       			}
       		}
	    	else if ($ref = StockGetEtfReference($strSymbol))	$arEtfRef[] = $ref;
       		else	$ref = StockGetReference($sym);
        }

        if ($strInternalLink = SelectStockLink($strSymbol, $bChinese))
        {
            $ref->SetExternalLink($strInternalLink);
            $ref->extended_ref = false;	// do not display extended trading information in adrcn.php page
        }

        $arRef[] = $ref;
        if ($sym->IsTradable())
        {
            $arTransactionRef[] = $ref;
        }
    }
    
    StockHistoryUpdate($arRef);    
    if (UrlGetQueryValue('sort') == false)	EchoReferenceParagraph($arRef, $bChinese);
    if (count($arFund) > 0)     				EchoFundArrayEstParagraph($arFund, $bChinese);
    if (count($arHShareRef) > 0)			EchoAhParagraph($arHShareRef, $bChinese);
    if (count($arHAdrRef) > 0)				EchoAdrhParagraph($arHAdrRef, $bChinese);
    if (count($arEtfRef) > 0)				EchoEtfListParagraph($arEtfRef, $bChinese);
    
    return $arTransactionRef;
}

function _echoMyStockGroup($strGroupId, $bChinese)
{
    global $group;  // in _stocklink.php $group = false;
    
    $arStock = SqlGetStocksArray($strGroupId);
    if (count($arStock) == 0)	return;

    $arTransactionRef = _echoStockGroupArray($arStock, $bChinese); 
    if (StockGroupIsReadOnly($strGroupId) == false)
    {
        $group = new MyStockGroup($strGroupId, $arTransactionRef);
        _EchoTransactionParagraph($group, $bChinese);
    }
    EchoStockGroupParagraph($bChinese);
}

function _getMetaDescriptionStr($strTitle, $bChinese)
{
    switch ($strTitle)
    {
    case 'adr':
        if ($bChinese)  $str = '通过比较中国企业在美国发行的American Depositary Receipt(ADR)的中国A股价格, 港股价格和美股价格, 分析各种套利对冲方案, 提供交易建议.';
        else              $str = 'Each of these tools compares the China/Hongkong/US market price of one American Depositary Receipt (ADR) and makes arbitrage analysis.';
        break;
        
    case 'adrhcompare':
        if ($bChinese)  $str = '美股ADR和香港H股全面价格比较工具, 按ADR股票代码排序. 主要显示H股交易情况, 同时计算AdrH价格比和HAdr价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.';
        else              $str = 'Compare the price of US ADR stock and Hongkong H stock, order by ADR stock symbols.';
        break;
  
    case 'ahcompare':
        if ($bChinese)  $str = '中国A股和香港H股全面价格比较工具, 按A股股票代码排序. 主要显示H股交易情况, 同时计算AH价格比和HA价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.';
        else              $str = 'Compare the price of Chinese A stock and Hongkong H stock, order by A stock symbols.';
        break;
  
    case 'bricfund':
        if ($bChinese)  $str = '计算金砖四国基金的净值, 目前包括信诚四国(SZ165510)和招商金砖(SZ161714). 招商金砖跟标普金砖四国40指数(^SPBRICNTR)比较一致.';
        else              $str = 'Estimate the net value of BRIC fund in Chinese market, including SZ165510 and SZ161714.';
        break;
  
    case 'chinaetf':
        if ($bChinese)  $str = '这个工具箱计算各种中国A股指数ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议. 包括美股ASHR和多家国内基金公司的A股沪深300指数ETF的配对交易等.';
        else              $str = 'Each of these tools estimates the net value of one Chinese ETF and makes available arbitrage analysis.';
        break;
        
    case 'chinainternet':
        if ($bChinese)  $str = '计算中国互联网指数基金的净值, 目前包括跟踪中证海外中国互联网指数的中国互联(SZ164906)和跟踪中证海外中国互联网50指数的中概互联(SH513050).';
        else              $str = 'Estimate the net value of CSI Overseas China Internet Index LOF, including SZ164906 and SH513050.';
        break;
        
    case 'commodity':
        if ($bChinese)  $str = '计算商品基金的净值, 目前包括大致对应跟踪GSG的信诚商品(SZ165513)和大致对应跟踪DBC的银华通胀(SZ161815). 跟踪商品期货的基金都有因为期货升水带来的损耗, 不能长期持有.';
        else              $str = 'Estimate the net value of commodity fund in Chinese market, including DBC related SZ161815 and GSG related SZ165513.';
        break;
        
    case 'etflist':
        if ($bChinese)  $str = '各个工具中用到的ETF跟指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况. 有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.';
        else              $str = 'List of all ETFs used in other tools, including following index, levergae ratio and calibration snapshot.';
        break;
  
    case 'goldetf':
        if ($bChinese)  $str = '中国A股的交易者普遍不理性, 当A股大跌的时候, 完全不相关的黄金ETF也经常会跟着跌, 这样会产生套利机会. 这个工具箱计算各种黄金ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        else              $str = 'Each of these tools estimates the net value of one Chinese Gold ETF and makes arbitrage analysis.';
        break;
        
    case 'gradedfund':
        if ($bChinese)  $str = '中国A股的分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性. 这个工具箱计算各种分级基金的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        else              $str = 'Each of these tools estimates the net value of one Chinese graded fund and makes arbitrage analysis.';
        break;
        
    case 'hangseng':
        if ($bChinese)  $str = '计算恒生指数基金的净值, 目前包括恒生ETF(SZ159920), 恒指LOF(SZ160924)和恒生通(SH513660). 使用恒生指数(^HSI)进行估值, 恒生指数盈富基金(02800)仅作为参考.';
        else              $str = 'Using ^HSI to estimate the net value of Hang Seng index fund in Chinese market, including SZ159920, SZ160924 and SH513660, 02800 as reference as well.';
        break;
        
    case 'hshares':
        if ($bChinese)  $str = '计算H股基金的净值, 目前包括H股ETF(SH510900)和恒生H股(SZ160717).使用恒生中国企业指数(^HSCE)估值, 恒生H股ETF(02828)仅用于参考.';
        else              $str = 'Estimate the net value of H-Share fund in Chinese market, including SH510900 and SZ160717.';
        break;
        
    case 'lof':
        if ($bChinese)  $str = '中国A股的LOF基金是个奇葩设计, 加上A股交易者普遍的不理性, 产生了很多套利机会. 这个工具箱计算各种LOF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        else              $str = 'Each of these tools estimates the net value of one Chinese LOF and makes arbitrage analysis.';
        break;
        
    case 'lofhk':
        if ($bChinese)  $str = '这个工具箱计算A股市场中各种香港LOF的净值. 直接导致把香港LOF从其它LOF页面分出来的原因是新基金华宝兴业香港中国中小盘QDII-LOF(SH501021)居然只有指数而没有对应的港股ETF, 只好用指数给所有港股LOF估值了.';
        else              $str = 'Each of these tools estimates the net value of one Chinese HK LOF and makes arbitrage analysis.';
        break;
        
    case 'oilfund':
        if ($bChinese)  $str = '计算原油基金的净值, 目前包括南方原油(SH501018), 国泰商品(SZ160216), 嘉实原油(SZ160723)和原油基金(SZ161129). 跟踪原油期货的基金都有因为期货升水带来的损耗, 不能长期持有. 用油气公司行业ETF做长期投资是更好的选择.';
        else              $str = 'Estimate the net value of oil fund in China. Must not hold oil future related fund for a long period. Oil company ETF is a better long term investment.';
        break;
        
    case 'qqqfund':
        if ($bChinese)  $str = '计算纳斯达克100基金的净值, 目前包括纳指ETF(SH513100)和纳指100(SZ159941). 使用纳斯达克100指数(^NDX)估值, QQQ仅用于参考.';
        else              $str = 'Estimate the net value of NASDAQ-100 fund in Chinese market, including SH513100 and SZ159941.';
        break;
        
    case 'spyfund':
        if ($bChinese)  $str = '计算标普500基金的净值, 目前包括沪市标普500(SH513500)和深市标普500(SZ161125).使用标普500指数(^GSPC)估值, SPY仅用于参考.';
        else              $str = 'Estimate the net value of S&P 500 fund in Chinese market, including SH513500 and SZ161125.';
        break;
    }
    return $str;
}

function _getSimilarLinks($strTitle, $bChinese)
{
    switch ($strTitle)
    {
    case 'ahcompare':
    	$str = GetExternalLink('https://www.jisilu.cn/data/ha/', ($bChinese ? '集思录' : 'Collective Record')).' '.GetExternalLink('http://data.10jqka.com.cn/market/ahgbj/', ($bChinese ? '同花顺' : 'Straight Flush'));
        break;
  
    case 'goldetf':
		$str = GetExternalLink('https://www.jisilu.cn/data/etf/#tlink_1', ($bChinese ? '集思录' : 'Collective Record'));
        break;
        
    case 'gradedfund':
		$str = GetExternalLink('https://www.jisilu.cn/data/sfnew/#tlink_3', ($bChinese ? '集思录' : 'Collective Record'));
        break;
        
    case 'lof':
		$str = GetExternalLink('https://www.jisilu.cn/data/qdii/', ($bChinese ? '集思录' : 'Collective Record'));
        break;
        
    case 'lofhk':
		$str = GetExternalLink('https://www.jisilu.cn/data/lof/#index', ($bChinese ? '集思录' : 'Collective Record'));
        break;
        
    default:
    	return '';
    }
    return '<br />'.($bChinese ? '类似软件' : 'Similar Software').': '.$str;
}

function EchoAll($bChinese = true)
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
        if ($strGroupId = UrlGetQueryValue('groupid'))
        {
            _echoMyStockGroup($strGroupId, $bChinese);
        }
        else
        {
            _echoStockGroupParagraph($bChinese);
        }
    }
    else
    {
    	$str = _getMetaDescriptionStr($strTitle, $bChinese);
    	$str .= _getSimilarLinks($strTitle, $bChinese);
    	EchoParagraph($str);
        _echoStockGroupArray(StockGetArraySymbol(GetCategoryArray($strTitle)), $bChinese);
    }
    EchoPromotionHead($bChinese, $strTitle);
    EchoStockCategory($bChinese);
}

function EchoMetaDescription($bChinese = true)
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	if ($strGroupId = UrlGetQueryValue('groupid'))
    	{
    		$str = _GetWhoseStockGroupDisplay(false, $strGroupId, $bChinese);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay(AcctGetMemberId(), AcctIsLogin(), $bChinese);
    		$str .= _GetAllDisplay(false, $bChinese);
    	}

        if ($bChinese)  $str .= '股票分组管理页面. 提供现有股票分组列表和编辑删除链接, 以及新增加股票分组的输入控件. 跟php/_editgroupform.php和php/_submitgroup.php配合使用.';
        else             $str .= ' stock groups management, working together with php/_editgroupform.php and php/_submitgroup.php.';
    }
    else
    {
    	$str = _getMetaDescriptionStr($strTitle, $bChinese);
    }
    EchoMetaDescriptionText($str);
}

function _getTitleStr($strTitle, $bChinese)
{
    switch ($strTitle)
    {
    case 'adr':
    	$str = $bChinese ? '美股ADR价格比较工具' : 'Price Compare Tools for ADR';
        break;
        
    case 'adrhcompare':
    	$str = $bChinese ? '美股ADR和H股价格比较工具' : 'ADR and H Compare Tools';
        break;
  
    case 'ahcompare':
    	$str = $bChinese ? 'AH股价格比较工具' : 'AH Compare Tools';
        break;
  
    case 'bricfund':
    	$str = $bChinese ? '金砖四国基金净值计算工具' : 'BRIC Fund Net Value Tools';
        break;
  
    case 'chinaetf':
    	$str = $bChinese ? 'A股指数ETF净值计算工具' : 'Chinese ETF Net Value Tools';
        break;
        
    case 'chinainternet':
    	$str = $bChinese ? '中国互联网指数基金净值计算工具' : 'Overseas China Internet LOF Net Value Tools';
        break;
        
    case 'commodity':
    	$str = $bChinese ? '商品基金净值计算工具' : 'Commodity Fund Net Value Tools';
        break;
        
    case 'etflist':
    	$str = $bChinese ? 'ETF对照表' : 'ETF List';
        break;
  
    case 'goldetf':
    	$str = $bChinese ? 'A股黄金ETF净值计算工具' : 'Chinese Gold ETF Net Value Tools';
        break;
        
    case 'gradedfund':
    	$str = $bChinese ? 'A股分级基金分析工具' : 'Chinese Graded Fund Analysis Tools';
        break;
        
    case 'hangseng':
    	$str = $bChinese ? '恒生指数基金净值计算工具' : 'Hang Seng Index Fund Net Value Tools';
        break;
        
    case 'hshares':
    	$str = $bChinese ? 'H股基金净值计算工具' : 'H-Share Fund Net Value Tools';
        break;
        
    case 'lof':
    	$str = $bChinese ? 'A股LOF基金净值计算工具' : 'Chinese LOF Net Value Tools';
        break;
        
    case 'lofhk':
    	$str = $bChinese ? 'A股香港LOF基金净值计算工具' : 'Chinese HK LOF Net Value Tools';
        break;
        
    case 'oilfund':
    	$str = $bChinese ? '原油基金净值计算工具' : 'Oil Fund Net Value Tools';
        break;
        
    case 'qqqfund':
    	$str = $bChinese ? '纳斯达克100基金净值计算工具' : 'NASDAQ-100 Fund Net Value Tools';
        break;
        
    case 'spyfund':
    	$str = $bChinese ? '标普500基金净值计算工具' : 'S&P 500 Fund Net Value Tools';
        break;
    }
    return $str;
}

function EchoTitle($bChinese = true)
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	$strMemberId = AcctIsLogin(); 
    	if ($strGroupId = UrlGetQueryValue('groupid'))
    	{
    		$str = _GetWhoseStockGroupDisplay($strMemberId, $strGroupId, $bChinese);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay(AcctGetMemberId(), $strMemberId, $bChinese);
    		$str .= _GetAllDisplay(false, $bChinese);
    	}
   
    	if ($bChinese)  $str .= '股票分组';
    	else
    	{
    		$str .= ' Stock Group';
    		if (!$strGroupId)  $str .= 's'; 
    	}
    }
    else
    {
    	$str = _getTitleStr($strTitle, $bChinese);
    }
    	
    echo $str;
}

function EchoHeadLine($bChinese = true)
{
	EchoTitle($bChinese);
}

    AcctSessionStart();
    if (UrlGetTitle() == 'mystockgroup')
    {   // mystockgroupcn.php
        if (UrlGetQueryValue('groupid'))
        {
            AcctCheckLogin();
        }
        else
        {
            if (UrlGetQueryValue('email'))
            {
                AcctCheckLogin();
            }
            else
            {
                AcctMustLogin();
            }
        }
    }
    else
    {
        AcctCheckLogin();
    }

?>

