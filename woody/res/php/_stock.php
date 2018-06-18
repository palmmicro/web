<?php
require_once('_resstock.php');
require_once('/php/stock.php');
//require_once('/php/ui/stocktable.php');
require_once('/php/ui/transactionparagraph.php');
require_once('_editformcommon.php');
require_once('_edittransactionform.php');
require_once('_stocklink.php');
require_once('_stockgroup.php');

function _GetStockConfigDebugString($ar_ref, $bChinese)
{
	$arSma = GetSmaTableColumn($bChinese);
    $str = $arSma[0];
    foreach ($ar_ref as $ref)
    {
        if ($ref)
        {
            $str .= ' '.$ref->DebugConfigLink();
        }
    }
    return $str;
}

// ****************************** Portfolio table *******************************************************

function _EchoPortfolioParagraphBegin($str, $bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)	$arColumn = array($strSymbol, '总数量', '平均价格', '百分比', '持仓', '盈亏', '货币');
    else		        $arColumn = array($strSymbol, 'Total', 'Avg', 'Percentage', 'Amount', 'Profit', 'Money');
    
    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="portfolio">
        <tr>
            <td class=c1 width=100 align=center>{$arColumn[0]}</td>
            <td class=c1 width=90 align=center>{$arColumn[1]}</td>
            <td class=c1 width=90 align=center>{$arColumn[2]}</td>
            <td class=c1 width=100 align=center>{$arColumn[3]}</td>
            <td class=c1 width=120 align=center>{$arColumn[4]}</td>
            <td class=c1 width=90 align=center>{$arColumn[5]}</td>
            <td class=c1 width=50 align=center>{$arColumn[6]}</td>
        </tr>
END;
}

function _EchoPortfolioItem($strGroupId, $trans, $bChinese)
{
    $ref = $trans->ref;
    $sym = $ref->GetSym();
    
    if ($sym->IsSymbolA())           $strMoney = '';
    else if ($sym->IsSymbolH())     $strMoney = $bChinese ? '港币$' : 'HK$';
    else                              $strMoney = '$';
    
    $strTransactions = StockGetTransactionLink($strGroupId, $sym->GetSymbol(), $bChinese);
    if ($trans->iTotalShares == 0)
    {
        $strAvgCost = '';
        $strPercentage = '';
        $strAmount = '';
    }
    else
    {
        $strAvgCost = $trans->GetAvgCostDisplay();
        $strPercentage = $ref->GetPercentageDisplay($trans->GetAvgCost());
        $strAmount = $trans->GetValueDisplay();
    }
    $strTotalShares = strval($trans->iTotalShares); 
    $strProfit = $trans->GetProfitDisplay();
    
    echo <<<END
    <tr>
        <td class=c1>$strTransactions</td>
        <td class=c1>$strTotalShares</td>
        <td class=c1>$strAvgCost</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strAmount</td>
        <td class=c1>$strProfit</td>
        <td class=c1>$strMoney</td>
    </tr>
END;
}

function _echoGroupPortfolioParagraph($group, $bChinese)
{
    if ($group->GetTotalRecords() > 0)
	{
	    _EchoPortfolioParagraphBegin(GetMyPortfolioLink($bChinese), $bChinese);    
        foreach ($group->arStockTransaction as $trans)
        {
            if ($trans->iTotalRecords > 0)
            {
                _EchoPortfolioItem($group->strGroupId, $trans, $bChinese);
            }
		}
		EchoTableParagraphEnd();
	}
}

// ****************************** Money table *******************************************************

function _EchoMoneyParagraphBegin($bChinese, $str = '')
{
    $strGroupLink = GetMyStockGroupLink($bChinese);
    if ($bChinese)     
    {
        $arColumn = array($strGroupLink, '持仓', '盈亏', '全部持仓', '全部盈亏', '货币');
    }
    else
    {
        $arColumn = array($strGroupLink, 'Value', 'Profit', 'All Value', 'All Profit', 'Money');
    }
    
    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="money">
        <tr>
            <td class=c1 width=110 align=center>{$arColumn[0]}</td>
            <td class=c1 width=100 align=center>{$arColumn[1]}</td>
            <td class=c1 width=100 align=center>{$arColumn[2]}</td>
            <td class=c1 width=140 align=center>{$arColumn[3]}</td>
            <td class=c1 width=140 align=center>{$arColumn[4]}</td>
            <td class=c1 width=50 align=center>{$arColumn[5]}</td>
        </tr>
END;
}

function _echoMoneyItem($strGroup, $strMoney, $fValue, $fProfit, $fConvertValue, $fConvertProfit)
{
    $strValue = GetNumberDisplay($fValue);
    $strProfit = GetNumberDisplay($fProfit);
    $strConvertValue = GetNumberDisplay($fConvertValue);
    $strConvertProfit = GetNumberDisplay($fConvertProfit);
    
    echo <<<END
    <tr>
        <td class=c1>$strGroup</td>
        <td class=c1>$strValue</td>
        <td class=c1>$strProfit</td>
        <td class=c1>$strConvertValue</td>
        <td class=c1>$strConvertProfit</td>
        <td class=c1>$strMoney</td>
    </tr>
END;
}

function _EchoMoneyGroupData($group, $strLink, $fUSDCNY, $fHKDCNY)
{
    $group->ConvertCurrency($fUSDCNY, $fHKDCNY);
    _echoMoneyItem($strLink, '', $group->multi_amount->fCNY, $group->multi_profit->fCNY, $group->multi_amount->fConvertCNY, $group->multi_profit->fConvertCNY);
    if ((empty($group->multi_amount->fUSD) == false) || (empty($group->multi_profit->fUSD) == false))
        _echoMoneyItem('', '$', $group->multi_amount->fUSD, $group->multi_profit->fUSD, $group->multi_amount->fConvertUSD, $group->multi_profit->fConvertUSD);
    if ((empty($group->multi_amount->fHKD) == false) || (empty($group->multi_profit->fHKD) == false))
        _echoMoneyItem('', 'HK$', $group->multi_amount->fHKD, $group->multi_profit->fHKD, $group->multi_amount->fConvertHKD, $group->multi_profit->fConvertHKD);
}


// ****************************** Premotion Headline *******************************************************
function _getDevGuideLink($strVer, $bChinese)
{
    $str = '/woody/blog/entertainment/20150818';
    $str .= UrlGetPhp($bChinese);
    if ($strVer)
    {
        $str .= '#'.$strVer;
    }
    return GetInternalLink($str, $bChinese ? '开发记录' : 'Development Record');
}

function EchoPromotionHead($bChinese, $strVer = false)
{
    if ($bChinese)  echo '<h3>讨论和建议</h3>';
    else              echo '<h3>Discussions and Suggestions</h3>';
    
    if ($bChinese)
    {
        $iVal = rand(1, 3);
        if ($iVal == 1)          LayoutQQgroupPromotion();
        else if ($iVal == 2)    LayoutWeixinPromotion();
        else if ($iVal == 3)    LayoutMyPromotion();
    }
    EchoParagraph(_getDevGuideLink($strVer, $bChinese));
}

// ****************************** Money Paragraph *******************************************************

function EchoMoneyParagraph($group, $bChinese, $fUSDCNY = false, $fHKDCNY = false)
{
    if ($bChinese)     
    {                                          
        $str = '折算货币';
    }
    else
    {
        $str = 'Convert currency';
    }
    _EchoMoneyParagraphBegin($bChinese, $str);
    _EchoMoneyGroupData($group, $group->strName, $fUSDCNY, $fHKDCNY);
    EchoTableParagraphEnd();
}

// ****************************** Transaction Paragraph *******************************************************

function _EchoTransactionParagraph($group, $bChinese)
{
    $strGroupId = $group->strGroupId;
    
    if ($group->GetTotalRecords() > 0)
    {
    	EchoTransactionParagraph($strGroupId, $bChinese);
    }
    StockEditTransactionForm($bChinese, $strGroupId);
    _echoGroupPortfolioParagraph($group, $bChinese);
}

// ****************************** String functions *******************************************************

function _getMemberDisplay($strMemberId)
{
	if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
	{
	    return SqlGetEmailById($strMemberId);
	}
	return $strName;
}

function _GetWhoseDisplay($strOwnerMemberId, $strMemberId, $bChinese)
{
    if ($strOwnerMemberId == $strMemberId)
    {
        if ($bChinese)  $str = '我的';
        else             $str = 'My ';
    }
    else
    {
	    $str = _getMemberDisplay($strOwnerMemberId);
        if ($bChinese)  $str .= '的';
        else             $str .= "'s ";
    }
    return $str;
}

function _GetWhoseStockGroupDisplay($strMemberId, $strGroupId, $bChinese)
{
    if ($strGroupMemberId = SqlGetStockGroupMemberId($strGroupId))
    {
    	$str = _GetWhoseDisplay($strGroupMemberId, $strMemberId, $bChinese); 
    	return $str.SqlGetStockGroupName($strGroupId);
    }
    return '';
}

function _GetAllDisplay($str, $bChinese)
{
    if ($str)   return $str;
    
    if ($bChinese)  $str = '全部';
    else             $str = 'All';
    return $str;
}

function _GetStockDisplay($ref, $bChinese)
{
    return RefGetDescription($ref, $bChinese).'('.$ref->GetStockSymbol().')';
}

?>
