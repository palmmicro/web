<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
//require_once('/php/stockgroup.php');
require_once('/php/ui/referenceparagraph.php');

class _MyPortfolio extends StockGroup
{
    var $arStockGroup = array();
    
    // constructor 
    function _MyPortfolio() 
    {
        parent::StockGroup();
    }
}

function _echoPortfolio($portfolio, $sql, $bChinese)
{
    $arRef = array();
    _EchoPortfolioParagraphBegin($bChinese ? '个股盈亏' : 'Stock performance', $bChinese);    
	if ($result = $sql->GetAll()) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $group = new MyStockGroup($stockgroup['id'], array());
		    if ($group->GetTotalRecords() > 0)
		    {
		        $portfolio->arStockGroup[] = $group;
		        foreach ($group->arStockTransaction as $trans)
		        {
		            if ($trans->iTotalRecords > 0)
		            {
		                _EchoPortfolioItem($stockgroup['id'], $trans, $bChinese);
		                $portfolio->OnStockTransaction($trans);
		                if (!in_array($trans->ref, $arRef))    $arRef[] = $trans->ref;
		            }
		        }
		    }
		}
		@mysql_free_result($result);
	}
    EchoTableParagraphEnd();    

    StockHistoryUpdate($arRef);    
    $arRef = RefSortBySymbol($arRef);
    foreach ($arRef as $ref)
    {
    	RefSetExternalLinkMyStock($ref, $bChinese);
    }
    EchoReferenceParagraph($arRef);
}

function _echoMoneyParagraph($portfolio, $bChinese)
{
    $fUSDCNY = SqlGetUSCNY();
    $fHKDCNY = SqlGetHKCNY();    

    _EchoMoneyParagraphBegin();
    foreach ($portfolio->arStockGroup as $group)
    {
        _EchoMoneyGroupData($group, GetStockGroupLink($group->strGroupId, $bChinese), $fUSDCNY, $fHKDCNY);
    }
    _EchoMoneyGroupData($portfolio, ($bChinese ? '全部' : 'All'), $fUSDCNY, $fHKDCNY);
    EchoTableParagraphEnd();
}

function _onPrefetch($sql) 
{
	if ($result = $sql->GetAll()) 
	{
	    $arSymbol = array();
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $arSymbol = array_merge($arSymbol, SqlGetStocksArray($stockgroup['id'], true));
		}
		@mysql_free_result($result);
	}
    StockPrefetchArrayData($arSymbol);
}

function EchoMyFortfolio($bChinese = true)
{
	$sql = new StockGroupSql(AcctGetMemberId());
    _onPrefetch($sql);

    $portfolio = new _MyPortfolio();
    _echoPortfolio($portfolio, $sql, $bChinese);
    _echoMoneyParagraph($portfolio, $bChinese);
    
    EchoPromotionHead('portfolio');
}

    AcctEmailAuth();

?>

