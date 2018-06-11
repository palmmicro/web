<?php
require_once('_stock.php');
require_once('_editgroupform.php');
//require_once('/php/stockgroup.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/stockgroupparagraph.php');

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
    StockPrefetchData($arStock);
    GetChinaMoney();
/*    if (in_array('USCNY', $arStock) && in_array('HKCNY', $arStock))
    {	
//    	DebugString('USCNY and HKCNY in stockgroup together, need Forex prefetch.');
        PrefetchEastMoneyData(array('USCNY', 'HKCNY'));
    }*/
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

        $strInternalLink = SelectSymbolInternalLink($strSymbol, $bChinese);
        if ($strInternalLink != $strSymbol)
        {
            $ref->strExternalLink = $strInternalLink;
            $ref->extended_ref = false;	// do not display extended trading information in adrcn.php page
        }

        $arRef[] = $ref;
        if ($sym->IsTradable())
        {
            $arTransactionRef[] = $ref;
        }
    }
    
    EchoReferenceParagraph($arRef, $bChinese);
    if (count($arFund) > 0)     		EchoFundArrayEstParagraph($arFund, $bChinese);
    if (count($arHShareRef) > 0)	EchoAhParagraph($arHShareRef, $bChinese);
    if (count($arHAdrRef) > 0)		EchoAdrhParagraph($arHAdrRef, $bChinese);
    if (count($arEtfRef) > 0)		EchoEtfListParagraph($arEtfRef, $bChinese);
    
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

function MyStockGroupEchoAll($bChinese)
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
        _echoStockGroupArray(StockGetArraySymbol(GetCategoryArray($strTitle)), $bChinese);
    }
    EchoPromotionHead($bChinese, $strTitle);
}

function MyStockGroupEchoMetaDescription($bChinese)
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
    EchoMetaDescriptionText($str);
}

function MyStockGroupEchoTitle($bChinese)
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

