<?php
require_once('_stock.php');
require_once('_editgroupform.php');
require_once('/php/stockhis.php');
//require_once('/php/stockgroup.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/fundestparagraph.php');

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

function _echoStockGroupArray($arStock)
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

        if ($strInternalLink = SelectStockLink($strSymbol))
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
    if (UrlGetQueryValue('sort') == false)	EchoReferenceParagraph($arRef);
    if (count($arFund) > 0)     				EchoFundArrayEstParagraph($arFund);
    if (count($arHShareRef) > 0)			EchoAhParagraph($arHShareRef);
    if (count($arHAdrRef) > 0)				EchoAdrhParagraph($arHAdrRef);
    if (count($arEtfRef) > 0)				EchoEtfListParagraph($arEtfRef);
    
    return $arTransactionRef;
}

function _echoMyStockGroup($strGroupId)
{
    global $group;  // in _stocklink.php $group = false;
    
    $arStock = SqlGetStocksArray($strGroupId);
    if (count($arStock) == 0)	return;

    $arTransactionRef = _echoStockGroupArray($arStock); 
    if (StockGroupIsReadOnly($strGroupId) == false)
    {
        $group = new MyStockGroup($strGroupId, $arTransactionRef);
        _EchoTransactionParagraph($group);
    }
    EchoStockGroupParagraph();
}

function _getMetaDescriptionStr($strTitle)
{
    switch ($strTitle)
    {
    case 'adr':
        $str = '通过比较中国企业在美国发行的American Depositary Receipt(ADR)的中国A股价格, 港股价格和美股价格, 分析各种套利对冲方案, 提供交易建议.';
        break;
        
    case 'adrhcompare':
        $str = '美股ADR和香港H股全面价格比较工具, 按ADR股票代码排序. 主要显示H股交易情况, 同时计算AdrH价格比和HAdr价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.';
        break;
  
    case 'ahcompare':
        $str = '中国A股和香港H股全面价格比较工具, 按A股股票代码排序. 主要显示H股交易情况, 同时计算AH价格比和HA价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.';
        break;
  
    case 'bricfund':
        $str = '计算金砖四国基金的净值, 目前包括信诚四国(SZ165510)和招商金砖(SZ161714). 招商金砖跟标普金砖四国40指数(^SPBRICNTR)比较一致.';
        break;
  
    case 'chinaetf':
        $str = '这个工具箱计算各种中国A股指数ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议. 包括美股ASHR和多家国内基金公司的A股沪深300指数ETF的配对交易等.';
        break;
        
    case 'chinainternet':
        $str = '计算中国互联网指数基金的净值, 目前包括跟踪中证海外中国互联网指数的中国互联(SZ164906)和跟踪中证海外中国互联网50指数的中概互联(SH513050).';
        break;
        
    case 'commodity':
        $str = '计算商品基金的净值, 目前包括大致对应跟踪GSG的信诚商品(SZ165513)和大致对应跟踪DBC的银华通胀(SZ161815). 跟踪商品期货的基金都有因为期货升水带来的损耗, 不能长期持有.';
        break;
        
    case 'etflist':
        $str = '各个工具中用到的ETF跟指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况. 有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.';
        break;
  
    case 'goldetf':
        $str = '中国A股的交易者普遍不理性, 当A股大跌的时候, 完全不相关的黄金ETF也经常会跟着跌, 这样会产生套利机会. 这个工具箱计算各种黄金ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        break;
        
    case 'gradedfund':
        $str = '中国A股的分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性. 这个工具箱计算各种分级基金的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        break;
        
    case 'hangseng':
        $str = '计算恒生指数基金的净值, 目前包括恒生ETF(SZ159920), 恒指LOF(SZ160924)和恒生通(SH513660). 使用恒生指数(^HSI)进行估值, 恒生指数盈富基金(02800)仅作为参考.';
        break;
        
    case 'hshares':
        $str = '计算H股基金的净值, 目前包括H股ETF(SH510900)和恒生H股(SZ160717).使用恒生中国企业指数(^HSCE)估值, 恒生H股ETF(02828)仅用于参考.';
        break;
        
    case 'lof':
        $str = '中国A股的LOF基金是个奇葩设计, 加上A股交易者普遍的不理性, 产生了很多套利机会. 这个工具箱计算各种LOF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.';
        break;
        
    case 'lofhk':
        $str = '这个工具箱计算A股市场中各种香港LOF的净值. 直接导致把香港LOF从其它LOF页面分出来的原因是新基金华宝兴业香港中国中小盘QDII-LOF(SH501021)居然只有指数而没有对应的港股ETF, 只好用指数给所有港股LOF估值了.';
        break;
        
    case 'oilfund':
        $str = '计算原油基金的净值, 目前包括南方原油(SH501018), 国泰商品(SZ160216), 嘉实原油(SZ160723)和原油基金(SZ161129). 跟踪原油期货的基金都有因为期货升水带来的损耗, 不能长期持有. 用油气公司行业ETF做长期投资是更好的选择.';
        break;
        
    case 'qqqfund':
        $str = '计算纳斯达克100基金的净值, 目前包括纳指ETF(SH513100)和纳指100(SZ159941). 使用纳斯达克100指数(^NDX)估值, QQQ仅用于参考.';
        break;
        
    case 'spyfund':
        $str = '计算标普500基金的净值, 目前包括沪市标普500(SH513500)和深市标普500(SZ161125).使用标普500指数(^GSPC)估值, SPY仅用于参考.';
        break;
    }
    return $str;
}

function _getSimilarLinks($strTitle)
{
    switch ($strTitle)
    {
    case 'ahcompare':
    	$str = GetExternalLink('https://www.jisilu.cn/data/ha/', '集思录').' '.GetExternalLink('http://data.10jqka.com.cn/market/ahgbj/', '同花顺');
        break;
  
    case 'goldetf':
		$str = GetExternalLink('https://www.jisilu.cn/data/etf/#tlink_1', '集思录');
        break;
        
    case 'gradedfund':
		$str = GetExternalLink('https://www.jisilu.cn/data/sfnew/#tlink_3', '集思录');
        break;
        
    case 'lof':
		$str = GetExternalLink('https://www.jisilu.cn/data/qdii/', '集思录');
        break;
        
    case 'lofhk':
		$str = GetExternalLink('https://www.jisilu.cn/data/lof/#index', '集思录');
        break;
        
    default:
    	return '';
    }
    return '<br />类似软件: '.$str;
}

function EchoAll()
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
        if ($strGroupId = UrlGetQueryValue('groupid'))
        {
            _echoMyStockGroup($strGroupId);
        }
        else
        {
        	EchoStockGroupParagraph();	
        	StockEditGroupForm(STOCK_GROUP_NEW_CN);
        }
    }
    else
    {
    	$str = _getMetaDescriptionStr($strTitle);
    	$str .= _getSimilarLinks($strTitle);
    	EchoParagraph($str);
        _echoStockGroupArray(StockGetArraySymbol(GetCategoryArray($strTitle)));
    }
    EchoPromotionHead($strTitle);
    EchoStockCategory();
}

function EchoMetaDescription()
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	if ($strGroupId = UrlGetQueryValue('groupid'))
    	{
    		$str = _GetWhoseStockGroupDisplay(false, $strGroupId);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay(AcctGetMemberId(), AcctIsLogin());
    		$str .= _GetAllDisplay(false);
    	}

        $str .= '股票分组管理页面. 提供现有股票分组列表和编辑删除链接, 以及新增加股票分组的输入控件. 跟php/_editgroupform.php和php/_submitgroup.php配合使用.';
    }
    else
    {
    	$str = _getMetaDescriptionStr($strTitle);
    }
    EchoMetaDescriptionText($str);
}

function _getTitleStr($strTitle)
{
    switch ($strTitle)
    {
    case 'adr':
    	$str = '美股ADR价格比较工具';
        break;
        
    case 'adrhcompare':
    	$str = '美股ADR和H股价格比较工具';
        break;
  
    case 'ahcompare':
    	$str = 'AH股价格比较工具';
        break;
  
    case 'bricfund':
    	$str = '金砖四国基金净值计算工具';
        break;
  
    case 'chinaetf':
    	$str = 'A股指数ETF净值计算工具';
        break;
        
    case 'chinainternet':
    	$str = '中国互联网指数基金净值计算工具';
        break;
        
    case 'commodity':
    	$str = '商品基金净值计算工具';
        break;
        
    case 'etflist':
    	$str = 'ETF对照表';
        break;
  
    case 'goldetf':
    	$str = 'A股黄金ETF净值计算工具';
        break;
        
    case 'gradedfund':
    	$str = 'A股分级基金分析工具';
        break;
        
    case 'hangseng':
    	$str = '恒生指数基金净值计算工具';
        break;
        
    case 'hshares':
    	$str = 'H股基金净值计算工具';
        break;
        
    case 'lof':
    	$str = 'A股LOF基金净值计算工具';
        break;
        
    case 'lofhk':
    	$str = 'A股香港LOF基金净值计算工具';
        break;
        
    case 'oilfund':
    	$str = '原油基金净值计算工具';
        break;
        
    case 'qqqfund':
    	$str = '纳斯达克100基金净值计算工具';
        break;
        
    case 'spyfund':
    	$str = '标普500基金净值计算工具';
        break;
    }
    return $str;
}

function EchoTitle()
{
    $strTitle = UrlGetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	$strMemberId = AcctIsLogin(); 
    	if ($strGroupId = UrlGetQueryValue('groupid'))
    	{
    		$str = _GetWhoseStockGroupDisplay($strMemberId, $strGroupId);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay(AcctGetMemberId(), $strMemberId);
    		$str .= _GetAllDisplay(false);
    	}
    	$str .= '股票分组';
    }
    else
    {
    	$str = _getTitleStr($strTitle);
    }
    	
    echo $str;
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

