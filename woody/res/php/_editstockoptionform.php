<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/gb2312.php');
require_once('/php/sql/sqlstock.php');
require_once('/php/ui/htmlelement.php');

define ('STOCK_OPTION_ADJCLOSE_CN', '根据分红更新复权收盘价');

define ('STOCK_OPTION_EDIT', 'Edit Stock Description');
define ('STOCK_OPTION_EDIT_CN', '修改股票说明');

define ('STOCK_OPTION_REVERSESPLIT', 'Reverse Split Stock');
define ('STOCK_OPTION_REVERSESPLIT_CN', '股票合股');

define ('STOCK_OPTION_AMOUNT', 'Set Fund Purchase Amount');
define ('STOCK_OPTION_AMOUNT_CN', '设置基金申购金额');

function _getStockOptionDate($strSubmit, $strSymbol)
{
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT)
	{
		if ($history = SqlGetStockHistoryNow(SqlGetStockId($strSymbol)))
		{
			return $history['date'];
		}
	}
	return '';
}

function _getStockOptionDescription($strSubmit, $strSymbol)
{
    $stock = SqlGetStock($strSymbol);
    $sym = new StockSymbol($strSymbol);
        
    if ($strFutureSymbol = IsSinaFutureSymbol($strSymbol))     $ref_sina = new FutureReference($strFutureSymbol);
    else                                                            $ref_sina = new SinaStockReference($strSymbol);
        
    if ($strSubmit == STOCK_OPTION_EDIT_CN)
    {
        $strDescription = $stock['cn'].'-'.FromGB2312ToUTF8($ref_sina->strChineseName);
        if ($sym->IsFundA())
        {
            $fund_ref = new FundReference($strSymbol);
            $strDescription .= '-'.FromGB2312ToUTF8($fund_ref->strChineseName);
        }
    }
    else
    {
        $ref = new YahooStockReference($strSymbol);
        $strDescription = $stock['us'].'-'.$ref->strName.'-'.FromGB2312ToUTF8($ref_sina->strName);
    }
    return $strDescription;
}

function _getStockOptionAmount($strSymbol)
{
   	if ($str = SqlGetFundPurchaseAmount(AcctIsLogin(), SqlGetStockId($strSymbol)))
   	{
    	return $str;
    }
    return FUND_PURCHASE_AMOUNT;
}

function _getStockOptionVal($strSubmit, $strSymbol)
{
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN)
	{
		return '0.01';
	}
	else if ($strSubmit == STOCK_OPTION_EDIT_CN || $strSubmit == STOCK_OPTION_EDIT)
	{
		return _getStockOptionDescription($strSubmit, $strSymbol);
	}
	else if ($strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT)
	{
		return '10';
	}
	else if ($strSubmit == STOCK_OPTION_AMOUNT_CN || $strSubmit == STOCK_OPTION_AMOUNT)
	{
		return _getStockOptionAmount($strSymbol);
	}
	return '';
}

function StockOptionEditForm($strSubmit)
{
    $strEmail = AcctGetEmail(); 
	$strEmailReadonly = HtmlElementReadonly();
	
	$strSymbol = UrlGetQueryValue('symbol');
	$strSymbolReadonly = HtmlElementReadonly();
	
    $strDateDisabled = '';
    if (($strDate = _getStockOptionDate($strSubmit, $strSymbol)) == '')
    {
    	$strDateDisabled = HtmlElementDisabled();
    }
    
    $strVal = _getStockOptionVal($strSubmit, $strSymbol);
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	    }
	</script>
	
	<form id="stockoptionForm" name="stockoptionForm" method="post" action="/woody/res/php/_submitstockoptions.php">
        <div>
		<p><input name="login" value="$strEmail" type="text" size="40" maxlength="128" class="textfield" id="login" $strEmailReadonly />
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
