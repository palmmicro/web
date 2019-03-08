<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/ui/stockgroupparagraph.php');
require_once('_editgroupform.php');

function _adjustLofPriceFactor($strLofSymbol, $fLof, $fEst, $fCNY)
{
    $fFactor = $fEst * $fCNY / $fLof;
    return $fFactor;
}

function _adjustEtfPriceFactor($strEstSymbol, $fEst, $fEtf)
{
    $fFactor = $fEst / $fEtf;
    return $fFactor;
}

function _onAdjust($strSymbols)
{
    $ar = explode('&', $strSymbols);
    
    $ar0 = explode('=', $ar[0]);
    $strSymbol = $ar0[0];
    $fVal = floatval($ar0[1]);
    
    $ar1 = explode('=', $ar[1]);
    $strSymbol2 = $ar1[0];
    $fVal2 = floatval($ar1[1]);
    
    $iCount = count($ar);
    if ($iCount > 2)
    {
        $ar2 = explode('=', $ar[2]);
    }
    
    $fFactor = false;
    if (in_arrayLof($strSymbol) || in_arrayLofHk($strSymbol))
    {
        $fFactor = _adjustLofPriceFactor($strSymbol, $fVal, $fVal2, floatval($ar2[1]));
    }
    else if (in_arrayGoldEtf($strSymbol))
    {
        $fFactor = _adjustEtfPriceFactor($strSymbol, $fVal2, $fVal);
    }
    
    if ($fFactor !== false)
    {
        SqlInsertStockCalibration(SqlGetStockId($strSymbol), ' ', $ar0[1], $ar1[1], $fFactor, DebugGetTimeDisplay());
    }
}

function _onDelete($strGroupId)
{
    if (StockGroupIsReadOnly($strGroupId))  return;
    SqlDeleteStockGroupItemByGroupId($strGroupId);
    SqlDeleteTableDataById(TABLE_STOCK_GROUP, $strGroupId);
}

function _emailStockGroup($strMemberId, $strGroupId, $strSymbols)
{
    $strSubject = 'Stock Group: '.$_POST['submit'];
	$str = GetMemberLink($strMemberId);
    $str .= '<br />GroupName: '.GetStockGroupLink($strGroupId); 
    $str .= '<br />Symbols: '.$strSymbols; 
    EmailReport($str, $strSubject); 
}

function _getStockIdArray($strSymbols)
{
	$arStockId = array();
    $arSymbol = StockGetSymbolArray($strSymbols);
	foreach ($arSymbol as $strSymbol)
	{
	    $strStockId = SqlGetStockId($strSymbol);
	    if ($strStockId == false)
	    {
            $ref = StockGetReference(new StockSymbol($strSymbol));
            if ($ref->HasData())
            {
            	$strStockId = $ref->GetStockId();
            }
            else
            {
            	continue;
            }
	    }
	    $arStockId[] = $strStockId; 
	}
	return $arStockId;
}

function _onEdit($strMemberId, $strGroupId, $strGroupName, $strSymbols)
{
    if (StockGroupIsReadOnly($strGroupId))  return;

    $str = SqlGetStockGroupName($strGroupId);
    if (in_arrayAll($str))  $strGroupName = $str;
    
	$sql = new StockGroupSql($strMemberId);
    if ($sql->Update($strGroupId, $strGroupName))
    {
    	SqlUpdateStockGroup($strGroupId, _getStockIdArray($strSymbols));
    }
    _emailStockGroup($strMemberId, $strGroupId, $strSymbols);
}

function _onNew($strMemberId, $strGroupName, $strSymbols)
{
	$sql = new StockGroupSql($strMemberId);
	$sql->Insert($strGroupName);
    if ($strGroupId = $sql->GetId($strGroupName))
    {
    	$item_sql = new StockGroupItemSql($strGroupId);
        $arStockId = _getStockIdArray($strSymbols);
        foreach ($arStockId as $strStockId)
        {
        	$item_sql->Insert($strStockId);
        }
    }
    _emailStockGroup($strMemberId, $strGroupId, $strSymbols);
}

    $strMemberId = AcctAuth();

	if ($strGroupId = UrlGetQueryValue('delete'))
	{
	    _onDelete($strGroupId);
	}
	else if (isset($_POST['submit']))
	{
		$strSymbols = UrlCleanString($_POST['symbols']);
		$strGroupName = UrlCleanString($_POST['groupname']);

		$strGroupId = UrlGetQueryValue('edit');
		if ($_POST['submit'] == STOCK_GROUP_EDIT || $_POST['submit'] == STOCK_GROUP_EDIT_CN)
		{	// edit group
		    _onEdit($strMemberId, $strGroupId, $strGroupName, $strSymbols);
		}
		else if ($_POST['submit'] == STOCK_GROUP_ADJUST_CN)
		{
		    _onAdjust($strSymbols); 
		}
		else if ($_POST['submit'] == STOCK_GROUP_NEW || $_POST['submit'] == STOCK_GROUP_NEW_CN)
		{
		    _onNew($strMemberId, $strGroupName, $strSymbols);
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
