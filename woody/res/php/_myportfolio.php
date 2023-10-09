<?php
require_once('_stock.php');
require_once('../../php/stockgroup.php');
require_once('../../php/stockhis.php');
require_once('../../php/ui/referenceparagraph.php');

class _MyPortfolio extends StockGroup
{
    var $arStockGroup = array();
    
    function _MyPortfolio() 
    {
        parent::StockGroup();
    }
}

function _transSortBySymbol($arTrans)
{
    $ar = array();
    foreach ($arTrans as $trans)
    {
    	$ref = $trans->GetRef();
        $strSymbol = $ref->GetSymbol();
        if (isset($ar[$strSymbol]))		array_push($ar[$strSymbol], $trans);
        else					        	$ar[$strSymbol] = array($trans);
    }
    ksort($ar);
    
    $arSort = array();
    foreach ($ar as $str => $arTrans)	$arSort = array_merge($arSort, $arTrans);
    return $arSort;
}

function _transEchoReferenceParagraph($arTrans, $bAdmin)
{
	$arRef = array();
	$arSymbol = array();
	
	foreach ($arTrans as $trans)
	{
		$ref = $trans->GetRef();
		$strSymbol = $ref->GetSymbol();
       	if (!in_array($strSymbol, $arSymbol))
       	{
       		$arRef[] = $ref;
       		$arSymbol[] = $strSymbol;
       	}
	}
	
	foreach ($arRef as $ref)		$his = new StockHistory($ref);		// Stock history update
    EchoReferenceParagraph($arRef, $bAdmin);
}

function _echoMergeParagraph($arMerge)
{
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnTotalShares(),
								   new TableColumnTest()
								   ), 'merge', '合并数量');

	foreach ($arMerge as $strSymbol => $trans)
	{
		$iTotal = $trans->GetTotalShares();
		if ($iTotal != 0)
		{
			$ar = array();
		
			$ref = $trans->GetRef();
			if ($ref->IsSymbolUS())	$ar[] = GetTradingViewLink($strSymbol);
			else						$ar[] = RefGetMyStockLink($ref);
			
			$ar[] = strval($iTotal);
			switch ($strSymbol)
			{
			case 'KWEB':
				$ar[] = strval($iTotal + 1400 - 2093);
				break;

			case 'TLT':
				$ar[] = strval($iTotal - 200);
				break;
			}
			RefEchoTableColumn($ref, $ar);
		}
	}
    EchoTableParagraphEnd();
}

function _transEchoMergeParagraph($arTrans)
{
	$arMerge = array();
	$arSymbol = array();
	$prev_trans = false;
	$cur_trans = false;
	
	foreach ($arTrans as $trans)
	{
		$strSymbol = $trans->GetSymbol();
       	if (in_array($strSymbol, $arSymbol))
       	{
       		if ($cur_trans == false)
       		{
       			$cur_trans = new MyStockTransaction($trans->GetRef());
       			$cur_trans->Add($prev_trans);
       		}
   			$cur_trans->Add($trans);
       	}
       	else
       	{
       		$arSymbol[] = $strSymbol;
       		if ($cur_trans)
       		{
       			$strPrevSymbol = $prev_trans->GetSymbol();
       			$arMerge[$strPrevSymbol] = $cur_trans;
       			$cur_trans = false;
       		}
       		$prev_trans = $trans;
       	}
	}

	if ($cur_trans)	$arMerge[$strSymbol] = $cur_trans;
	if (count($arMerge) > 0)		_echoMergeParagraph($arMerge);
}

function _echoPortfolio($portfolio, $sql, $strMemberId, $bAdmin)
{
	$arTransA = array();
	$arTransH = array();
	$arTransUS = array();
	
	if ($result = $sql->GetAll($strMemberId)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
		    $group = new MyStockGroup($record['id'], array());
		    if ($group->GetTotalRecords() > 0)
		    {
		        $portfolio->arStockGroup[] = $group;
		        foreach ($group->arStockTransaction as $trans)
		        {
		            if ($trans->GetTotalRecords() > 0)
		            {
		                $portfolio->OnStockTransaction($trans);
		                $ref = $trans->GetRef();
		                if ($ref->IsSymbolA())	       	$arTransA[] = $trans;
		                else if ($ref->IsSymbolH())      	$arTransH[] = $trans;
		                else			                	$arTransUS[] = $trans;
		            }
		        }
		    }
		}
		mysqli_free_result($result);
	}

	$arTrans = array_merge(_transSortBySymbol($arTransA), _transSortBySymbol($arTransH), _transSortBySymbol($arTransUS));
    _transEchoReferenceParagraph($arTrans, $bAdmin);
	EchoPortfolioParagraph($arTrans);
    _transEchoMergeParagraph($arTrans);
}

function _onPrefetch($sql, $strMemberId) 
{
    $arSymbol = array();
	if ($result = $sql->GetAll($strMemberId)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
		    $arSymbol = array_merge($arSymbol, SqlGetStocksArray($record['id'], true));
		}
		mysqli_free_result($result);
	}
    StockPrefetchArrayData($arSymbol);
}

function EchoAll()
{
	global $acct;
	
	$strMemberId = $acct->GetMemberId();
	$sql = $acct->GetGroupSql();
    _onPrefetch($sql, $strMemberId);

    $portfolio = new _MyPortfolio();
    _echoPortfolio($portfolio, $sql, $strMemberId, $acct->IsAdmin());
    
    $portfolio->arStockGroup[] = $portfolio; 
    $acct->EchoMoneyParagraphs($portfolio->arStockGroup, new CnyReference('USCNY'), new CnyReference('HKCNY'));
    
    $acct->EchoLinks('myportfolio');
}

function GetTitle()
{
	global $acct;
	return $acct->GetWhoseDisplay().MY_PORTFOLIO_DISPLAY;
}

function GetMetaDescription()
{
	global $acct;
	
    $str = $acct->GetWhoseDisplay().MY_PORTFOLIO_DISPLAY.'页面。根据用户输入的交易详情汇总证券投资组合信息，显示包括单个股票的盈亏情况，分组投资盈亏情况以及总体盈亏情况等内容。用来跟踪和记录长期投资表现。';
    return CheckMetaDescription($str);
}

	$acct = new StockAccount();
	if ($acct->GetMemberId() == false)
	{
		$acct->Auth();
	}

?>

