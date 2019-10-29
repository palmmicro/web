<?php
require_once('_resstock.php');
require_once('/php/stock.php');
//require_once('/php/ui/stocktable.php');
require_once('/php/ui/transactionparagraph.php');
require_once('_editformcommon.php');
require_once('_edittransactionform.php');
require_once('_stocklink.php');
require_once('_stockgroup.php');

// ****************************** Portfolio table *******************************************************

function _EchoPortfolioParagraphBegin($str)
{
    $arColumn = array(GetTableColumnSymbol(), '总数量', '平均价格', GetTableColumnChange(), '持仓', '盈亏', '货币');
    
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

function _EchoPortfolioItem($strGroupId, $trans)
{
    $ref = $trans->ref;
    $sym = $ref->GetSym();
    
    if ($sym->IsSymbolA())           $strMoney = '';
    else if ($sym->IsSymbolH())     $strMoney = '港币$';
    else                              $strMoney = '$';
    
    $strTransactions = StockGetTransactionLink($strGroupId, $sym->GetSymbol());
    if ($trans->iTotalShares == 0)
    {
        $strAvgCost = '';
        $strPercentage = '';
        $strAmount = '';
        $strTotalShares = '';
    }
    else
    {
        $strAvgCost = $trans->GetAvgCostDisplay();
        $strPercentage = $ref->GetPercentageDisplay($trans->GetAvgCost());
        $strAmount = GetNumberDisplay($trans->GetValue());
        $strTotalShares = strval($trans->iTotalShares); 
    }
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

function _echoGroupPortfolioParagraph($group)
{
    if ($group->GetTotalRecords() > 0)
	{
	    _EchoPortfolioParagraphBegin(GetMyPortfolioLink());    
        foreach ($group->arStockTransaction as $trans)
        {
            if ($trans->iTotalRecords > 0)
            {
                _EchoPortfolioItem($group->GetGroupId(), $trans);
            }
		}
		EchoTableParagraphEnd();
	}
}

// ****************************** Money table *******************************************************

function _EchoMoneyParagraphBegin($str = '')
{
    $strGroupLink = GetMyStockGroupLink();
    $arColumn = array($strGroupLink, '持仓', '盈亏', '全部持仓', '全部盈亏', '货币');
    
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

function _EchoMoneyGroupData($group, $strLink, $strUSDCNY, $strHKDCNY)
{
    $group->ConvertCurrency($strUSDCNY, $strHKDCNY);
    _echoMoneyItem($strLink, '', $group->multi_amount->fCNY, $group->multi_profit->fCNY, $group->multi_amount->fConvertCNY, $group->multi_profit->fConvertCNY);
    if ((empty($group->multi_amount->fUSD) == false) || (empty($group->multi_profit->fUSD) == false))
    {
        _echoMoneyItem('', '$', $group->multi_amount->fUSD, $group->multi_profit->fUSD, $group->multi_amount->fConvertUSD, $group->multi_profit->fConvertUSD);
    }
    if ((empty($group->multi_amount->fHKD) == false) || (empty($group->multi_profit->fHKD) == false))
    {
        _echoMoneyItem('', 'HK$', $group->multi_amount->fHKD, $group->multi_profit->fHKD, $group->multi_amount->fConvertHKD, $group->multi_profit->fConvertHKD);
    }
}


// ****************************** Premotion Headline *******************************************************
function EchoPromotionHead($strVer = false, $strLoginId = false)
{
    echo '<h3>讨论和建议</h3>';
    
    if (AcctNoAdv($strLoginId) == false)
	{
		$iVal = rand(1, 6);
		switch ($iVal)
		{
		case 1:
			LayoutWeixinPromotion();
			break;
        	
		case 2:
			LayoutWeixinPay();
			break;
        	
		case 3:
   			LayoutAliPay();
			break;

		case 4:
			LayoutBrokerYinhe();
			break;

		case 5:
			LayoutBrokerHuatai();
			break;

		case 6:
			LayoutBrokerXueying();
			break;
		}
    }
    EchoParagraph(GetDevGuideLink('20150818', $strVer));
}

// ****************************** Money Paragraph *******************************************************

function EchoMoneyParagraph($group, $strUSDCNY = false, $strHKDCNY = false)
{
    _EchoMoneyParagraphBegin('折算货币');
    _EchoMoneyGroupData($group, $group->strName, $strUSDCNY, $strHKDCNY);
    EchoTableParagraphEnd();
}

// ****************************** Transaction Paragraph *******************************************************

function _EchoTransactionParagraph($group)
{
    $strGroupId = $group->GetGroupId();
    
    if ($group->GetTotalRecords() > 0)
    {
    	EchoTransactionParagraph($strGroupId);
    }
    StockEditTransactionForm(STOCK_TRANSACTION_NEW, $strGroupId);
    _echoGroupPortfolioParagraph($group);
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

function _GetWhoseDisplay($strOwnerMemberId, $strMemberId)
{
    $str = ($strOwnerMemberId == $strMemberId) ? '我' : _getMemberDisplay($strOwnerMemberId);
    return $str.'的';
}

function _GetWhoseStockGroupDisplay($strMemberId, $strGroupId)
{
    if ($strGroupMemberId = SqlGetStockGroupMemberId($strGroupId))
    {
    	$str = _GetWhoseDisplay($strGroupMemberId, $strMemberId); 
    	return $str.SqlGetStockGroupName($strGroupId);
    }
    return '';
}

function _GetAllDisplay($str)
{
    return ($str) ? $str : '全部';
}


?>
