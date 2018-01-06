<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _getStockGroupEditString($strGroupId, $bChinese)
{
    $strStocks = '';
	$arStock = SqlGetStocksArray($strGroupId);
	foreach ($arStock as $strSymbol)
	{
	    $strStocks .= StockGetEditLink($strSymbol, $bChinese).', ';
	}
	$strStocks = rtrim($strStocks, ', ');
	return $strStocks;
}

// ****************************** Stock group table *******************************************************

function _echoStockGroupTableItem($stockgroup, $bReadOnly, $bChinese)
{
    $strGroupId = $stockgroup['id'];
    
    if ($bReadOnly)
    {
        $strDelete = '';
        $strEdit = '';
    }
    else
    {
        $strDelete = UrlGetDeleteLink(STOCK_PHP_PATH.'_submitgroup.php?delete='.$strGroupId, '股票分组和相关交易记录', 'stock group and related stock transactions', $bChinese);
        $strEdit = StockGetEditGroupLink($strGroupId, $bChinese);
    }
    $strLink = SelectGroupInternalLink($strGroupId, $bChinese);
	
    if (AcctIsAdmin())
	{
	    $strStocks = _getStockGroupEditString($strGroupId, $bChinese);
	}
	else
	{
	    $strStocks = SqlGetStocksString($strGroupId);
	}

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strEdit $strDelete</td>
    </tr>
END;
}

function _echoStockGroupTableData($strMemberId, $bReadOnly, $bChinese)
{
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    _echoStockGroupTableItem($stockgroup, $bReadOnly, $bChinese);
		}
		@mysql_free_result($result);
	}
}

function _echoStockGroupTable($strMemberId, $bReadOnly, $bChinese)
{
    if ($bChinese)
    {
        $arColumn = array('分组名称', '股票', '操作');
    }
    else
    {
        $arColumn = array('Group Name', 'Stocks', 'Operation');
    }
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stockgroup">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=440 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
    </tr>
END;
    _echoStockGroupTableData($strMemberId, $bReadOnly, $bChinese);
    EchoTableEnd();
}

function _echoMyStockGroup($strGroupId, $bReadOnly, $bChinese)
{
    global $group;  // in _stocklink.php $group = false;
    
    $arStock = SqlGetStocksArray($strGroupId);
//    sort($arStock);
    WeixinStockPrefetchData($arStock);
    
    $arRef = array();
    $arTransactionRef = array();
    $arFund = array();
    $arRefAH = array();
    foreach ($arStock as $strSymbol)
    {
        $sym = new StockSymbol($strSymbol);
        if (in_arrayFuture($strSymbol))
        {
            $ref = new MyFutureReference($strSymbol);
        }
        else if ($sym->IsFundA())
        {
            $fund = WeixinStockGetFundReference($strSymbol);
            $arFund[] = $fund;
            $ref = $fund->stock_ref; 
        }
        else
        {
            $ref = new MyStockReference($strSymbol);
            if ($ref->h_ref)        $arRefAH[] = $ref;
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
    $group = new MyStockGroup($strGroupId, $arTransactionRef);
    
    EchoReferenceParagraph($arRef, $bChinese);
    if (count($arFund) > 0)     EchoFundEstParagraph($arFund, '', $bChinese);
    if (count($arRefAH) > 0)    EchoAHStockParagraph($arRefAH, $bChinese);

    if (!$bReadOnly)
    {
        _EchoTransactionParagraph($group, $bChinese);
        EchoEditGroupEchoParagraph($strGroupId, $bChinese);
    }
}

function MyStockGroupEchoAll($strSubmit, $bChinese)
{
    global $g_strMemberId;
    global $g_strGroupId;
    global $group;  // in _stocklink.php $group = false;
    
    if ($g_strGroupId)
    {
        $bReadOnly = IsStockGroupReadOnly($g_strGroupId);
        _echoMyStockGroup($g_strGroupId, $bReadOnly, $bChinese);
    }
    else
    {
        $bReadOnly = AcctIsReadOnly($g_strMemberId);
        _echoStockGroupTable($g_strMemberId, $bReadOnly, $bChinese);
        if ($bReadOnly == false)
        {
            StockEditGroupForm($strSubmit, $bChinese);
        }
    }
    
    EchoPromotionHead('stockgroup', $bChinese);
    if (AcctIsAdmin())
    {
        if ($group)
        {   
    	    $strStocks = _getStockGroupEditString($g_strGroupId, $bChinese);
    	    EchoParagraph('修改股票说明: '.$strStocks);
        }
    }
}

function MyStockGroupEchoMetaDescription($bChinese)
{
    global $g_strMemberId;
    global $g_strGroupId;

    if ($g_strGroupId)
    {
        $str = _GetWhoseStockGroupDisplay(false, $g_strGroupId, $bChinese);
    }
    else
    {
        $str = _GetWhoseDisplay($g_strMemberId, AcctIsLogin(), $bChinese);
        $str .= _GetAllDisplay(false, $bChinese);
    }
    
    if ($bChinese)  $str .= '股票分组管理页面. 提供现有股票分组列表和编辑删除链接, 以及新增加股票分组的输入控件. 跟php/_editgroupform.php和php/_submitgroup.php配合使用.';
    else             $str .= ' stock groups management, working together with php/_editgroupform.php and php/_submitgroup.php.';
    EchoMetaDescriptionText($str);
}

function MyStockGroupEchoTitle($bChinese)
{
    global $g_strMemberId;
    global $g_strGroupId;

    if ($g_strGroupId)
    {
        $str = _GetWhoseStockGroupDisplay($g_strMemberId, $g_strGroupId, $bChinese);
    }
    else
    {
        $str = _GetWhoseDisplay($g_strMemberId, AcctIsLogin(), $bChinese);
        $str .= _GetAllDisplay(false, $bChinese);
    }
    
    if ($bChinese)  $str .= '股票分组';
    else
    {
        $str .= ' Stock Group';
        if (!$g_strGroupId)  $str .= 's'; 
    }
    echo $str;
}

    $g_strMemberId = false;
    AcctSessionStart();
    if ($g_strGroupId = UrlGetQueryValue('groupid'))
    {
        $g_strMemberId = AcctCheckLogin();
    }
    else
    {
        $g_strMemberId = AcctEmailQueryLogin();
    }

?>

