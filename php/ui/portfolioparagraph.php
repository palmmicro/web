<?php
require_once('stocktable.php');

function _echoPortfolioTableItem($trans)
{
	$ar = array();
	
    $ref = $trans->ref;
    if ($ref->IsSymbolA())           $strMoney = '';
    else if ($ref->IsSymbolH())     $strMoney = 'HK$';
    else                               $strMoney = '$';
    
    $ar[] = StockGetTransactionLink($trans->GetGroupId(), $ref->GetSymbol());
    $ar[] = $trans->GetProfitDisplay().$strMoney;
    $iShares = $trans->GetTotalShares();
    if ($iShares != 0)
    {
        $ar[] = GetNumberDisplay($trans->GetValue()).$strMoney;
        $ar[] = strval($iShares); 
        $ar[] = $trans->GetAvgCostDisplay();
        $ar[] = $ref->GetPercentageDisplay($trans->GetAvgCost());
    }

    EchoTableColumn($ar);
}

function EchoPortfolioParagraph($str, $arTrans)
{
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnAmount('盈亏'),
								   new TableColumnAmount('持仓'),
								   new TableColumnTotalShares(),
								   new TableColumnPrice('平均'),
								   new TableColumnChange()
								   ), MY_PORTFOLIO_PAGE, $str);

	foreach ($arTrans as $trans)
	{
		if ($trans->GetTotalRecords() > 0)
		{
			_echoPortfolioTableItem($trans);
		}
	}
    EchoTableParagraphEnd();
}

?>
