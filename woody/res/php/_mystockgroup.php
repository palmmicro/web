<?php
require_once('_stock.php');
require_once('_editgroupform.php');
require_once('/php/ui/ahparagraph.php');
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

function _echoStockGroupArray($arStock, $bChinese)
{
    MyStockPrefetchData($arStock);

    $hkcny_ref = new CNYReference('HKCNY');
    
    $arRef = array();
    $arTransactionRef = array();
    $arFund = array();
    $arHShareRef = array();
    foreach ($arStock as $strSymbol)
    {
        $sym = new StockSymbol($strSymbol);
        if (in_arrayFuture($strSymbol))	$ref = new MyFutureReference($strSymbol);
        else if ($sym->IsFundA())
        {
        	$fund = MyStockGetFundReference($strSymbol);
        	$arFund[] = $fund;
        	$ref = $fund->stock_ref; 
       	}
       	else
       	{
       		if ($sym->IsSymbolA())
       		{
       			$ref = new MyStockReference($strSymbol);
       			if ($strSymbolH = SqlGetAhPair($strSymbol))
       			{
       				if (in_array_ref($strSymbolH, $arHShareRef) == false)		$arHShareRef[] = new MyHShareReference($strSymbolH, $ref, $hkcny_ref);
       			}
       		}
       		else if ($sym->IsSymbolH())
       		{
       			if ($strSymbolA = SqlGetHaPair($strSymbol))	
       			{
       				if (($ref = in_array_ref($strSymbol, $arHShareRef)) == false)
       				{
       					$hshare_ref = new MyHShareReference($strSymbol, new MyStockReference($strSymbolA), $hkcny_ref);
       					$arHShareRef[] = $hshare_ref;
       					$ref = $hshare_ref;
       				}
       			}
       			else	$ref = new MyStockReference($strSymbol);
       		}
       		else	$ref = new MyStockReference($strSymbol);
        }

        $strInternalLink = SelectSymbolInternalLink($strSymbol, $bChinese);
        if ($strInternalLink != $strSymbol)
        {
            $ref->strExternalLink = $strInternalLink;
        }

        $arRef[] = $ref;
        if ($sym->IsIndex() == false)
        {
            $arTransactionRef[] = $ref;
        }
    }
    
    EchoReferenceParagraph($arRef, $bChinese);
    if (count($arFund) > 0)     EchoFundArrayEstParagraph($arFund, '', $bChinese);
    if (count($arHShareRef) > 0)	EchoAhParagraph($arHShareRef, $hkcny_ref, $bChinese);
    
    return $arTransactionRef;
}

function _echoEditGroupParagraph($strGroupId, $bChinese)
{
    $str = StockGetEditGroupLink($strGroupId, $bChinese);
    if ($bChinese)
    {
        $str .= '分组';
    }
    else
    {
        $str .= ' Group';
    }
    EchoParagraph($str);
}

function _echoMyStockGroup($strGroupId, $bChinese)
{
    global $group;  // in _stocklink.php $group = false;
    
    $arStock = SqlGetStocksArray($strGroupId);
//    sort($arStock);

    $arTransactionRef = _echoStockGroupArray($arStock, $bChinese); 
    if (IsStockGroupReadOnly($strGroupId) == false)
    {
        $group = new MyStockGroup($strGroupId, $arTransactionRef);
        _EchoTransactionParagraph($group, $bChinese);
        _echoEditGroupParagraph($strGroupId, $bChinese);
    }
    EchoParagraph(StockGroupGetStockLinks($strGroupId, $bChinese));
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
    
    EchoPromotionHead($strTitle, $bChinese);
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

