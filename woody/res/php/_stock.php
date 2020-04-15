<?php
require_once('_resstock.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
require_once('/php/ui/transactionparagraph.php');
require_once('/php/ui/portfolioparagraph.php');
require_once('_editformcommon.php');
require_once('_edittransactionform.php');
require_once('_stocklink.php');

// ****************************** Money table *******************************************************

function _EchoMoneyParagraphBegin($str = '')
{
    $strGroupLink = GetMyStockGroupLink();
    $arColumn = array($strGroupLink, '持仓', '盈亏', STOCK_DISP_ALL.'持仓', STOCK_DISP_ALL.'盈亏', '货币');
    
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


// ****************************** Promotion Headline *******************************************************

function _echoRandomPromotion()
{
	$iVal = rand(1, 4);
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
		LayoutQqGroup();
		break;
	}
}

function _isFromWeixin()
{
	if ($strFrom = UrlGetQueryValue('from'))
	{
		switch ($strFrom)
		{
		case 'groupmessage':
			LayoutQqGroup();
			DebugString('微信群');
			break;
			
		case 'singlemessage':
			LayoutWeixinPromotion();
			DebugString('好友分享');
			break;

		case 'timeline':
			LayoutWeixinPay();
			DebugString('朋友圈');
			break;
		}
		return true;
	}
	return false;
}

function _isFromQq()
{
	if ($strFrom = UrlGetQueryValue('tdsourcetag'))
	{
		switch ($strFrom)
		{
		case 's_pcqq_aiomsg':
			DebugString('QQ消息');
			break;
			
		case 's_pctim_aiomsg':
			DebugString('TIM消息');
			break;
		}
		LayoutQqGroup();
		return true;
	}
	return false;
}

function EchoPromotionHead($strVer = false, $strLoginId = false)
{
    echo '<h3>讨论和建议</h3>';
    
	if ((_isFromWeixin() == false) && (_isFromQq() == false))
	{
		_echoRandomPromotion();
    }
    
    $str = GetDevGuideLink('20150818', $strVer);
    EchoParagraph($str);
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
    
    StockEditTransactionForm(STOCK_TRANSACTION_NEW, $strGroupId);
    if ($group->GetTotalRecords() > 0)
    {
    	EchoTransactionParagraph($strGroupId);
		EchoPortfolioParagraph(GetMyPortfolioLink(), $group->GetStockTransactionArray());
	}
}

class StockAcctStart extends TitleAcctStart
{
    function StockAcctStart($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::TitleAcctStart($strQueryItem, $arLoginTitle);
    }

    function EchoLinks($strVer = false)
    {
    	$strLoginId = $this->GetLoginId();
    	EchoPromotionHead($strVer, $strLoginId);
    	EchoStockCategory($strLoginId);
    }
    
    function EchoStockGroupParagraph($strGroupId = false, $strStockId = false)
    {
    	EchoAllStockGroupParagraph($strGroupId, $strStockId, $this->GetMemberId(), $this->GetLoginId());
    }
}    

?>
