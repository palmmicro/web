<?php
require_once('_resstock.php');
require_once('_stockaccount.php');
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

function _EchoMoneyGroupData($group, $strUSDCNY, $strHKDCNY, $strLink = false)
{
	if ($strLink == false)	$strLink = GetStockGroupLink($group->GetGroupId());
	
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
	$iVal = rand(1, 5);
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
		LayoutTgGroup();
		break;
		
	case 5:
		LayoutPromo('dongfang', 'http://ognfhcacesaf4get.mikecrm.com/sEJIKQZ');
		break;
	}
}

function _isFromWeixin()
{
	if ($strFrom = UrlGetQueryValue('from'))
	{
		switch ($strFrom)
		{
		case 'groupmessage':	// 微信群
			LayoutTgGroup();
			return true;
			
		case 'singlemessage':	// 好友分享
			LayoutWeixinPromotion();
			return true;

		case 'timeline':		// 朋友圈
		case 'androidqq':		// ?
		case 'message':			// ?
			break;

		default:
			DebugString('未知WX消息 - '.$strFrom);
			break;
		}
		LayoutWeixinPay();
		return true;
	}
	return false;
}

function _isFromQq()
{
	if ($strFrom = UrlGetQueryValue('tdsourcetag'))
	{
		LayoutTgGroup();
		switch ($strFrom)
		{
		case 's_pcqq_aiomsg':	// QQ消息
		case 's_pctim_aiomsg':	// TIM消息?
			break;
			
		default:
			DebugString('未知QQ消息 - '.$strFrom);
			break;
		}
		return true;
	}
	return false;
}

// xueqiu_status_id=145895182&xueqiu_status_source=ptl_recommend
function _isFromXueQiu()
{
	if ($str = UrlGetQueryValue('xueqiu_status_id'))
	{
		DebugString('雪球'.$str);
		LayoutTgGroup();
		return true;
	}
	return false;
}

function EchoPromotionHead($strVer = false, $strLoginId = false)
{
    echo '<h3>相关链接</h3>';
    
	if ((_isFromWeixin() == false) && (_isFromQq() == false) && (_isFromXueQiu() == false))
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
    _EchoMoneyGroupData($group, $strUSDCNY, $strHKDCNY);
    EchoTableParagraphEnd();
}

?>
