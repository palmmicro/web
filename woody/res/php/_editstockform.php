<?php
require_once('/php/gb2312.php');

define ('STOCK_NEW', 'New Stock');
define ('STOCK_NEW_CN', '新股票');

define ('STOCK_EDIT', 'Edit Stock');
define ('STOCK_EDIT_CN', '修改股票');

function StockEditForm($strSubmit, $bChinese)
{
    $strPassQuery = UrlPassQuery();
    if ($bChinese)
    {
        $arColumn = array('股票', '说明', '操作');
        $strPassQuery .= '&cn=1'; 
    }
    else
    {
        $arColumn = array('Stock', 'Description', 'Operation');
    }
    $strReverseSplit = UrlBuildPhpLink(STOCK_PATH.'editstockreversesplit', UrlGetQueryString(), '合股', 'Reverse Split', $bChinese);

    $strSymbol = '';
    $strDescription = '';
    $strSymbolDisabled = '0';
    if ($strSymbol = UrlGetQueryValue('edit'))
    {
        $strSymbolDisabled = '1';
        $stock = SqlGetStock($strSymbol);
        $sym = new StockSymbol($strSymbol);
        
        if ($strFutureSymbol = IsSinaFutureSymbol($strSymbol))     $ref_sina = new FutureReference($strFutureSymbol);
        else                                                            $ref_sina = new SinaStockReference($strSymbol);
        
        if ($bChinese)
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
    }
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.stockForm.symbol.disabled = $strSymbolDisabled;
	    }
	</script>
	
	<form id="stockForm" name="stockForm" method="post" action="/woody/res/php/_submitstock.php$strPassQuery">
        <div>
		<p>{$arColumn[0]}
		<br /><input name="symbol" value="$strSymbol" type="text" size="20" maxlength="32" class="textfield" id="symbol" />
		<br />{$arColumn[1]}
		<br /><textarea name="description" rows="8" cols="75" id="description">$strDescription</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
    
    <div>
	    <p>$strReverseSplit
	    </p>
    </div>
END;
}

?>
