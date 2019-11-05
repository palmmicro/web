<?php
require_once('_stock.php');
require_once('_editgroupform.php');
require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');
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
       		else	$ref = StockGetReference($strSymbol, $sym);
        }

        if ($strInternalLink = GetStockLink($strSymbol))
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
	$ar = array(ADR_PAGE => '通过比较中国企业在美国发行的American Depositary Receipt(ADR)的中国A股价格, 港股价格和美股价格, 分析各种套利对冲方案, 提供交易建议.',
				  ADRH_COMPARE_PAGE => ADRH_COMPARE_DISPLAY.'工具, 按ADR股票代码排序. 主要显示H股交易情况, 同时计算AdrH价格比和HAdr价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.',
				  AH_COMPARE_PAGE => AH_COMPARE_DISPLAY.'工具, 按A股股票代码排序. 主要显示H股交易情况, 同时计算AH价格比和HA价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.',
				  'bricfund' => '计算金砖四国基金的净值, 目前包括信诚四国(SZ165510)和招商金砖(SZ161714). 招商金砖跟标普金砖四国40指数(^SPBRICNTR)比较一致.',
				  'chinaetf' => '这个工具箱计算各种中国A股指数ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议. 包括美股ASHR和多家国内基金公司的A股沪深300指数ETF的配对交易等.',
				  'chinainternet' => '计算中国互联网指数基金的净值, 目前包括跟踪中证海外中国互联网指数的中国互联(SZ164906)和跟踪中证海外中国互联网50指数的中概互联(SH513050).',
				  'commodity' => '计算商品基金的净值, 目前包括大致对应跟踪GSG的信诚商品(SZ165513)和大致对应跟踪DBC的银华通胀(SZ161815). 跟踪商品期货的基金都有因为期货升水带来的损耗, 不能长期持有.',
				  'etflist' => '各个工具中用到的ETF跟指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况. 有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.',
				  'goldetf' => '中国A股的交易者普遍不理性, 当A股大跌的时候, 完全不相关的黄金ETF也经常会跟着跌, 这样会产生套利机会. 这个工具箱计算各种黄金ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.',
				  'hangseng' => '计算恒生指数基金的净值, 目前包括恒生ETF(SZ159920), 恒指LOF(SZ160924)和恒生通(SH513660). 使用恒生指数(^HSI)进行估值, 恒生指数盈富基金(02800)仅作为参考.',
				  'hshares' => '计算H股基金的净值, 目前包括H股ETF(SH510900)和恒生H股(SZ160717).使用恒生中国企业指数(^HSCE)估值, 恒生H股ETF(02828)仅用于参考.',
				  'lof' => '中国A股的LOF基金是个奇葩设计, 加上A股交易者普遍的不理性, 产生了很多套利机会. 这个工具箱计算各种LOF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.',
				  'lofhk' => '这个工具箱计算A股市场中各种香港LOF的净值. 直接导致把香港LOF从其它LOF页面分出来的原因是有基金居然只有指数而没有对应的港股ETF, 只好用指数给所有港股LOF估值了.',
				  'oilfund' => '计算原油基金的净值, 目前包括南方原油(SH501018), 国泰商品(SZ160216), 嘉实原油(SZ160723)和原油基金(SZ161129). 跟踪原油期货的基金都有因为期货升水带来的损耗, 不能长期持有. 用油气公司行业ETF做长期投资是更好的选择.',
				  'qqqfund' => '计算纳斯达克100基金的净值, 目前包括纳指ETF(SH513100)和纳指100(SZ159941). 使用纳斯达克100指数(^NDX)估值, QQQ仅用于参考.',
				  'spyfund' => '计算标普500基金的净值, 目前包括沪市标普500(SH513500)和深市标普500(SZ161125).使用标普500指数(^GSPC)估值, SPY仅用于参考.',
				  );
    return $ar[$strTitle];
}

function _getSimilarLinks($strTitle)
{
    switch ($strTitle)
    {
    case ADR_PAGE:
    case ADRH_COMPARE_PAGE:
    	$str = GetAastocksLink();
        break;
  
    case AH_COMPARE_PAGE:
    	$str = GetExternalLink(GetJisiluDataUrl().'ha/', '集思录').' '.GetExternalLink('http://data.10jqka.com.cn/market/ahgbj/', '同花顺').' '.GetAastocksLink('ah');
        break;
  
    case 'goldetf':
		$str = GetJisiluGoldLink();
        break;
        
    case 'lof':
		$str = GetJisiluLofLink();
        break;
        
    case 'lofhk':
		$str = GetJisiluLofHkLink();
        break;
        
    default:
    	return '';
    }
    return '<br />类似软件: '.$str;
}

function EchoAll()
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
    if ($strTitle == 'mystockgroup')
    {
        if ($strGroupId = $acct->GetQuery())
        {
            _echoMyStockGroup($strGroupId);
        }
        else
        {
        	EchoStockGroupParagraph();	
        	StockEditGroupForm(STOCK_GROUP_NEW);
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
	global $acct;
	
	$strTitle = $acct->GetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	if ($strGroupId = $acct->GetQuery())
    	{
    		$str = _GetWhoseStockGroupDisplay(false, $strGroupId);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay($acct->GetMemberId(), $acct->GetLoginId());
    		$str .= _GetAllDisplay(false);
    	}
        $str .= '股票分组管理页面. 提供现有股票分组列表和编辑删除链接, 以及新增加股票分组的输入控件. 跟php/_editgroupform.php和php/_submitgroup.php配合使用.';
    }
    else
    {
    	$str = _getMetaDescriptionStr($strTitle);
    	if ($strQuery = UrlGetQueryValue('sort'))
    	{
    		$str .= ' '.GetSortString($strQuery).'.';
    	}
    }
    EchoMetaDescriptionText($str);
}

function _getTitleStr($strTitle)
{
	$ar = array(ADR_PAGE => ADR_DISPLAY,
				  ADRH_COMPARE_PAGE => ADRH_COMPARE_DISPLAY,
			  	  AH_COMPARE_PAGE => AH_COMPARE_DISPLAY,
			  	  'bricfund' => '金砖四国基金净值计算工具',
			  	  'chinaetf' => 'A股指数ETF净值计算工具',
			  	  'chinainternet' => '中国互联网指数基金净值计算工具',
			  	  'commodity' => '商品基金净值计算工具',
			  	  'etflist' => 'ETF对照表',
			  	  'goldetf' => 'A股黄金ETF净值计算工具',
			  	  'hangseng' => '恒生指数基金净值计算工具',
			  	  'hshares' => 'H股基金净值计算工具',
			  	  'lof'	=> 'A股LOF基金净值计算工具',
			  	  'lofhk' => 'A股香港LOF基金净值计算工具',
			  	  'oilfund'	=> '原油基金净值计算工具',
			  	  'qqqfund'	=> '纳斯达克100基金净值计算工具',
			  	  'spyfund'	=> '标普500基金净值计算工具',
			  	  );
    $str = $ar[$strTitle];
	if ($strQuery = UrlGetQueryValue('sort'))
	{
		$str .= '('.GetSortString($strQuery).')';
	}
    return $str;
}

function EchoTitle()
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
    if ($strTitle == 'mystockgroup')
    {
    	$strLoginId = $acct->GetLoginId(); 
    	if ($strGroupId = $acct->GetQuery())
    	{
    		$str = _GetWhoseStockGroupDisplay($strLoginId, $strGroupId);
    	}
    	else
    	{
    		$str = _GetWhoseDisplay($acct->GetMemberId(), $strLoginId);
    		$str .= _GetAllDisplay(false);
    	}
    	$str .= STOCK_GROUP_DISPLAY;
    }
    else
    {
    	$str = _getTitleStr($strTitle);
    }
    	
    echo $str;
}

	$acct = new TitleAcctStart('groupid');
	if ($acct->GetTitle() == 'mystockgroup')
	{
		if ($acct->GetQuery() == false)
		{
			if ($acct->GetMemberId() == false)
			{
				$acct->Auth();
			}
		}
	}

?>

