<?php
require_once('_emptygroup.php');

function _getStockOptionDate($strSubmit, $ref)
{
    $strStockId = $ref->GetStockId();
	$his_sql = GetStockHistorySql();
	switch ($strSubmit)
	{
	case STOCK_OPTION_DIVIDEND:
	case STOCK_OPTION_EMA:
	case STOCK_OPTION_HOLDINGS:
	case STOCK_OPTION_SHARE_DIFF:
	case STOCK_OPTION_SPLIT:
		if ($strDate = $his_sql->GetDateNow($strStockId))							return $strDate;
		break;

	case STOCK_OPTION_CLOSE:
		if ($record = $his_sql->GetRecordPrev($strStockId, $ref->GetDate()))	return $record['date'];
		break;

	case STOCK_OPTION_CALIBRATION:
	case STOCK_OPTION_NAV:
		$nav_sql = GetNavHistorySql();
		if ($strDate = $nav_sql->GetDateNow($strStockId))							return $strDate;
		if ($strDate = $his_sql->GetDateNow($strStockId))							return $strDate;
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
	$strName = SymGetStockName($ref);
	
    $str = $strName;
   	$str .= _getStockOptionNewName($ref, $strName);
    if ($ref->IsFundA())
    {
        $fund_ref = new FundReference($strSymbol);
        $str .= _getStockOptionNewName($fund_ref, $strName);
    }
    return $str;
}

function _getStockOptionAmount($strLoginId, $strStockId)
{
   	if ($str = SqlGetFundPurchaseAmount($strLoginId, $strStockId))
   	{
    	return $str;
    }
    return FUND_PURCHASE_AMOUNT;
}

function _getStockOptionAh($strSymbol)
{
	if ($strH = SqlGetAhPair($strSymbol))
	{
		return $strH;
	}
	return 'H';
}

function _getStockOptionHa($strSymbol)
{
	if ($strA = SqlGetHaPair($strSymbol))
	{
		return $strA;
	}
	return 'A';
}

function _getStockOptionAdr($strSymbol)
{
	$pair_sql = new AdrPairSql();
	if ($strAdr = $pair_sql->GetSymbol($strSymbol))
	{
		$pos_sql = new FundPositionSql();
		if ($fRatio = $pos_sql->ReadVal(SqlGetStockId($strAdr)))	return $strAdr.'/'.strval($fRatio);
		return $strAdr;
	}
	return 'ADR/100';
}

function _getStockOptionFund($strSymbol)
{
	$pair_sql = new FundPairSql();
	if ($strIndex = $pair_sql->GetPairSymbol($strSymbol))
	{
		$pos_sql = new FundPositionSql();
		if ($fRatio = $pos_sql->ReadVal(SqlGetStockId($strSymbol)))	return $strIndex.'*'.strval($fRatio);
		return $strIndex;
	}
	return 'INDEX*1';
}

function _getStockOptionEmaDays($strStockId, $strDate, $iDays)
{
	$sql = GetStockEmaSql($iDays);
	return $sql->GetClose($strStockId, $strDate);
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

function _getStockOptionSharesDiff($strStockId, $strDate)
{
	$sql = new SharesDiffSql();
	if ($str = $sql->GetClose($strStockId, $strDate))		return $str;

	$shares_sql = new SharesHistorySql();
	if ($strClose = $shares_sql->GetClose($strStockId, $strDate))
	{
		if ($strClosePrev = $shares_sql->GetClosePrev($strStockId, $strDate))
		{
			return strval(floatval($strClose) - floatval($strClosePrev));
		}
	}

	return '';
}

function _getStockOptionDividend($strStockId, $strDate)
{
	$sql = new StockDividendSql();
	if ($strClose = $sql->GetClose($strStockId, $strDate))
	{
		return $strClose;
	}
	return '1.00';
}

function _getBestEstNav($ref, $strDate)
{
	$strEst = SqlGetNavByDate($ref->GetStockId(), $strDate);
	if ($strEst == false)
    {
    	$strEst = $ref->GetClose($strDate);
   		if ($strEst == false)	$strEst = $ref->GetPrevPrice();
   	}
   	return $strEst;
}

function _getStockOptionCalibration($strSymbol, $strDate)
{
	$est_ref = false;
	if (in_arrayChinaIndex($strSymbol))
	{
	}
	else if (in_arrayGoldSilver($strSymbol))
	{
	}
	else if (in_arrayQdii($strSymbol))
	{
       	$fund = new QdiiReference($strSymbol);
       	$est_ref = $fund->GetEstRef();
	}
	else if (in_arrayQdiiHk($strSymbol))
	{
       	$fund = new QdiiHkReference($strSymbol);
       	$est_ref = $fund->GetEstRef();
	}
	else if (in_arrayQdiiJp($strSymbol))
	{
       	$fund = new QdiiJpReference($strSymbol);
       	$est_ref = $fund->GetEstRef();
	}
	else if (in_arrayQdiiEu($strSymbol))
	{
       	$fund = new QdiiEuReference($strSymbol);
       	$est_ref = $fund->GetEstRef();
	}
	else if ($strSymbol == 'SZ164906')
	{
		$est_ref = new MyStockReference('KWEB');
	}

	return $est_ref ? _getBestEstNav($est_ref, $strDate) : '对方净值';
}

function _getStockOptionVal($strSubmit, $strLoginId, $ref, $strSymbol, $strDate)
{
	$strStockId = $ref->GetStockId();
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADR:
		return _getStockOptionAdr($strSymbol);

	case STOCK_OPTION_AH:
		return _getStockOptionAh($strSymbol);

	case STOCK_OPTION_AMOUNT:
		return _getStockOptionAmount($strLoginId, $strStockId);
		
	case STOCK_OPTION_CALIBRATION:
		return _getStockOptionCalibration($strSymbol, $strDate); 
		
	case STOCK_OPTION_CLOSE:
		return $ref->GetPrevPrice();

	case STOCK_OPTION_DIVIDEND:
		return _getStockOptionDividend($strStockId, $strDate);

	case STOCK_OPTION_EDIT:
		return _getStockOptionName($ref, $strSymbol);
		
	case STOCK_OPTION_EMA:
		return _getStockOptionEma($strStockId, $strDate);

	case STOCK_OPTION_FUND:
		return _getStockOptionFund($strSymbol);

	case STOCK_OPTION_HA:
		return _getStockOptionHa($strSymbol);

	case STOCK_OPTION_HOLDINGS:
		return 'STOCK1*10.1;STOCK2*20.2;STOCK3*30.3;STOCK4*39.4';

	case STOCK_OPTION_NAV:
		return SqlGetNavByDate($strStockId, $strDate);

	case STOCK_OPTION_SHARE_DIFF:
		return _getStockOptionSharesDiff($strStockId, $strDate);

	case STOCK_OPTION_SPLIT:
		return '10:1';
	}
	return '';
}

function _getStockOptionMemo($strSubmit)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADR:
		return '输入SYMBOL/0删除对应ADR。';
		
	case STOCK_OPTION_AH:
		return '清空输入删除对应H股。';
		
	case STOCK_OPTION_CALIBRATION:
		return '清空输入删除对应日期校准值。';
		
	case STOCK_OPTION_DIVIDEND:
		return '清空输入删除对应分红。';
		
	case STOCK_OPTION_EMA:
		return '股票收盘后的第2天修改才会生效，同时删除以往全部EMA记录。';

	case STOCK_OPTION_FUND:
		return '输入INDEX*0删除对应关系和全部'.CALIBRATION_HISTORY_DISPLAY.'。';

	case STOCK_OPTION_HA:
		return '清空输入删除对应A股。';

	case STOCK_OPTION_HOLDINGS:
		return '输入STOCK*0删除对应基金持仓，用;号间隔多个持仓品种。';
		
	case STOCK_OPTION_NAV:
		return '清空输入删除对应日期净值。';

	case STOCK_OPTION_SHARE_DIFF:
		return '清空输入删除对应日期新增。';
		
	case STOCK_OPTION_SPLIT:
		return '输入1:10表示10股合1股，10:1表示1股拆10股，0:0删除对应日期数据。';
	}
	return '';
}

class SymbolEditAccount extends SymbolAccount
{
	function StockOptionEditForm($strSubmit)
	{
		$ref = $this->GetSymbolRef();
		$strEmail = $this->GetLoginEmail(); 
	
		$strEmailReadonly = HtmlElementReadonly();
		$strSymbol = $ref->GetSymbol();
//		$strSymbolReadonly = ($strSubmit == STOCK_OPTION_EDIT) ? '' : HtmlElementReadonly();
		$strSymbolReadonly = HtmlElementReadonly();
	
		$strDateDisabled = '';
		if (($strDate = _getStockOptionDate($strSubmit, $ref)) == '')
		{
			$strDateDisabled = HtmlElementDisabled();
		}
    
		$strVal = _getStockOptionVal($strSubmit, $this->GetLoginId(), $ref, $strSymbol, $strDate);
		$strMemo = GetInfoElement(_getStockOptionMemo($strSubmit));
	
		echo <<< END
	<script>
	    function OnLoad()
	    {
	    }
	</script>
	
	<form id="stockoptionForm" name="stockoptionForm" method="post" action="submitstockoptions.php">
        <div>
		<p>$strMemo
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
}

?>
