<?php

function ReverseSplitEditForm($bChinese)
{
    $strPassQuery = UrlPassQuery();
    if ($bChinese)
    {
        $arColumn = array('股票', '说明', '数量');
        $strSubmit = '合股';
    }
    else
    {
        $arColumn = array('Stock', 'Description', 'Number');
        $strSubmit = 'Reverse Split';
    }

    $strSymbol = '';
    $strDescription = '';
    $strSymbolDisabled = '1';
    $strDescriptionDisabled = '1';
    if ($strSymbol = UrlGetQueryValue('edit'))
    {
        $stock = SqlGetStock($strSymbol);
        if ($bChinese)
        {
            $strDescription = $stock['cn'];
        }
        else
        {
            $strDescription = $stock['us'];
        }
    }
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.stockForm.symbol.disabled = $strSymbolDisabled;
	        document.stockForm.description.disabled = $strDescriptionDisabled;
	    }
	</script>
	
	<form id="stockForm" name="stockForm" method="post" action="/woody/res/php/_submitreversesplit.php$strPassQuery">
        <div>
		<p>{$arColumn[0]}
		<br /><input name="symbol" value="$strSymbol" type="text" size="20" maxlength="32" class="textfield" id="symbol" />
		<br />{$arColumn[1]}
		<br /><textarea name="description" rows="8" cols="75" id="description">$strDescription</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
END;
}

?>
