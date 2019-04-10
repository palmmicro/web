<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/ui/htmlelement.php');

function _getStockOptionDate($strSubmit, $ref)
{
    $sql = $ref->GetHistorySql();
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADJCLOSE:
	case STOCK_OPTION_SPLIT:
	case STOCK_OPTION_EMA:
		if ($strDate = $sql->GetDateNow())
		{
			return $strDate;
		}
		break;

	case STOCK_OPTION_CLOSE:
		if ($record = $sql->GetPrev($ref->GetDate()))
		{
			return $record['date'];
		}
		break;
	}
	return '';
}

function _getStockOptionNewName($ref, $strName)
{
	$str = '';
	$strChinese = $ref->GetChineseName();
	$strEnglish = $ref->GetEnglishName();
	if ($strChinese != $strName)									$str .= '-'.$strChinese;
    if ($strEnglish != $strName && $strEnglish != $strChinese)	$str .= '-'.$strEnglish;
    return $str;
}

function _getStockOptionName($ref, $strSymbol)
{
    $record = SqlGetStock($strSymbol);
   	$strName = $record['name'];
    $str = $strName;
   	$str .= _getStockOptionNewName($ref, $strName);
    $sym = $ref->GetSym();
    if ($sym->IsFundA())
    {
        $fund_ref = new FundReference($strSymbol);
        $str .= _getStockOptionNewName($fund_ref, $strName);
    }
    return $str;
}

function _getStockOptionAmount($strSymbol)
{
   	if ($str = SqlGetFundPurchaseAmount(AcctIsLogin(), SqlGetStockId($strSymbol)))
   	{
    	return $str;
    }
    return FUND_PURCHASE_AMOUNT;
}

function _getStockOptionAdr($strSymbol)
{
	if ($strAdr = SqlGetHadrPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_ADRH_STOCK, SqlGetStockId($strAdr)))
		{
			return $strAdr.'/'.strval($fRatio);
		}
		return $strAdr;
	}
	return 'ADR/100';
}

function _getStockOptionAh($strSymbol)
{
	if ($strA = SqlGetHaPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_AH_STOCK, SqlGetStockId($strA)))
		{
			return $strA.'/'.strval($fRatio);
		}
		return $strA;
	}
	return 'A/1';
}

function _getStockOptionEtf($strSymbol)
{
	SqlCreateStockPairTable(TABLE_ETF_PAIR);
	if ($strIndex = SqlGetEtfPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_ETF_PAIR, SqlGetStockId($strSymbol)))
		{
			return $strIndex.'*'.strval($fRatio);
		}
		return $strIndex;
	}
	return 'INDEX*1';
}

function _getStockOptionEmaDays($strStockId, $strDate, $iDays)
{
	$sql = new StockEmaSql($strStockId, $iDays);
	return $sql->GetClose($strDate);
}

function _getStockOptionEma($strStockId, $strDate)
{
	$str200 = _getStockOptionEmaDays($strStockId, $strDate, 200);
	$str50 = _getStockOptionEmaDays($strStockId, $strDate, 50);
	if ($str200 && $str50)
	{
		return $str200.'/'.$str50;
	}
	return 'EMA200/50';
}

function _getStockOptionVal($strSubmit, $ref, $strSymbol, $strDate)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADJCLOSE:
		return '0.01';

	case STOCK_OPTION_ADR:
		return _getStockOptionAdr($strSymbol);

	case STOCK_OPTION_AH:
		return _getStockOptionAh($strSymbol);

	case STOCK_OPTION_CLOSE:
		return $ref->GetPrevPrice();

	case STOCK_OPTION_EMA:
		return _getStockOptionEma($ref->GetStockId(), $strDate);

	case STOCK_OPTION_ETF:
		return _getStockOptionEtf($strSymbol);

	case STOCK_OPTION_EDIT:
		return _getStockOptionName($ref, $strSymbol);

	case STOCK_OPTION_SPLIT:
		return '10:1';

	case STOCK_OPTION_AMOUNT:
		return _getStockOptionAmount($strSymbol);
	}
	return '';
}

function _getStockOptionMemo($strSubmit)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_EMA:
		return '股票收盘后的第2天修改才会生效, 输入0/0删除全部EMA记录.';

	case STOCK_OPTION_ETF:
		return '输入INDEX*0删除对应关系和全部校准记录.';

	case STOCK_OPTION_SPLIT:
		return '输入1:10表示10股合1股, 10:1表示1股拆10股.';

	case STOCK_OPTION_ADR:
	case STOCK_OPTION_AH:
		return '输入SYMBOL/0删除对应关系.';
	}
	return '';
}

function StockOptionEditForm($ref, $strSubmit)
{
    $strEmail = AcctGetEmail(); 
	$strEmailReadonly = HtmlElementReadonly();
	
	$strSymbol = $ref->GetStockSymbol();
//	$strSymbolReadonly = ($strSubmit == STOCK_OPTION_EDIT) ? '' : HtmlElementReadonly();
	$strSymbolReadonly = HtmlElementReadonly();
	
    $strDateDisabled = '';
    if (($strDate = _getStockOptionDate($strSubmit, $ref)) == '')
    {
    	$strDateDisabled = HtmlElementDisabled();
    }
    
    $strVal = _getStockOptionVal($strSubmit, $ref, $strSymbol, $strDate);
    $strMemo = _getStockOptionMemo($strSubmit);
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	    }
	</script>
	
	<form id="stockoptionForm" name="stockoptionForm" method="post" action="/woody/res/php/_submitstockoptions.php">
        <div>
		<p><font color=blue>$strMemo</font>
		<br /><input name="login" value="$strEmail" type="text" size="40" maxlength="128" class="textfield" id="login" $strEmailReadonly />
		<br /><input name="symbol" value="$strSymbol" type="text" size="20" maxlength="32" class="textfield" id="symbol" $strSymbolReadonly />
		<br /><input name="date" value="$strDate" type="text" size="10" maxlength="32" class="textfield" id="date" $strDateDisabled />
		<br /><textarea name="val" rows="8" cols="75" id="val">$strVal</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
END;
}

?>
