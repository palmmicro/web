<?php
require_once('_stock.php');
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

function _echoPortfolioTable($portfolio, $strMemberId, $bChinese)
{
    $arRef = array();
    _EchoPortfolioTableBegin($bChinese);    
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
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
    EchoTableEnd();    

    EchoNewLine();
    $arRef = StockReferenceSortBySymbol($arRef);
    foreach ($arRef as $ref)
    {
    	$ref->strExternalLink = GetMyStockRefLink($ref, $bChinese);
    }
    EchoReferenceTable($arRef, $bChinese);
}

function _echoMoneyTable($portfolio, $bChinese)
{
    $uscny_ref = new MyCnyReference('USCNY');
    $hkcny_ref = new MyCnyReference('HKCNY');
    $fUSDCNY = $uscny_ref->fPrice;
    $fHKDCNY = $hkcny_ref->fPrice;    

    _EchoMoneyTableBegin($bChinese);
    foreach ($portfolio->arStockGroup as $group)
    {
        _EchoMoneyGroupData($group, SelectGroupInternalLink($group->strGroupId, $bChinese), $fUSDCNY, $fHKDCNY);
    }
    _EchoMoneyGroupData($portfolio, ($bChinese ? '全部' : 'All'), $fUSDCNY, $fHKDCNY);
    EchoTableEnd();
}

function _onPrefetch($strMemberId) 
{
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
	    $arSymbol = array();
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $arSymbol = array_merge($arSymbol, SqlGetStockGroupPrefetchSymbolArray($stockgroup['id']));
		}
		@mysql_free_result($result);
	}
    MyStockPrefetchDataAndForex($arSymbol);
}

function EchoMyFortfolio($bChinese)
{
    global $strMemberId;
    
    _onPrefetch($strMemberId);
    $portfolio = new _MyPortfolio();
    
    EchoParagraphBegin($bChinese ? '个股盈亏' : 'Stock performance');
    _echoPortfolioTable($portfolio, $strMemberId, $bChinese);
    EchoParagraphEnd();
    
    EchoParagraphBegin($bChinese ? '持仓盈亏' : 'Overall performance');
    _echoMoneyTable($portfolio, $bChinese);
    EchoParagraphEnd();
    
    EchoPromotionHead('portfolio', $bChinese);
}

    $strMemberId = AcctEmailAuth();

?>

