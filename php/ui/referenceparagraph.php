<?php
require_once('stocktable.php');

function _greyString($str)
{
    return '<font color=grey>'.$str.'</font>';
}

function _italicString($str)
{
    return '<i>'.$str.'</i>';
}

function _boldString($str)
{
    return '<b>'.$str.'</b>';
}

function _convertDescription($str, $bChinese)
{
    $strDisplay = ConvertChineseDescription($str, $bChinese);
    
    if ($str == STOCK_SINA_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_SINA_FUTURE_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_YAHOO_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_PRE_MARKET)
    {
        $str = _italicString($strDisplay);
    }
    else if ($str == STOCK_POST_MARKET)
    {
        $str = _italicString($strDisplay);
    }
    else if ($str == STOCK_NET_VALUE)
    {
        $str = _boldString($strDisplay);
    }
    return $str;
}

function _checkStockReference($ref)
{
    if ($ref == false)                  return false;
//    if ($ref->bHasData == false)        return false;
//    if ($ref->strExternalLink == false) return false;
    return true;
}

// $ref from StockReference
function _echoReferenceTableItem($ref, $bChinese, $callback = false)
{
    if (_checkStockReference($ref) == false)    return;

    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPercentageDisplay = $ref->GetCurrentPercentageDisplay();
    if ($callback)
    {
        $strDisplayEx = '';
		$arDisplayEx = call_user_func($callback, $bChinese, $ref);
		foreach ($arDisplayEx as $str)
		{
			$strDisplayEx .= GetTableColumnDisplay($str);
		}
    }
    else
    {
    	if (AcctIsDebug())		$strDescription = $ref->DebugLink();
    	else					$strDescription = _convertDescription($ref->strDescription, $bChinese);
        $strDisplayEx = GetTableColumnDisplay($strDescription);
    }

    echo <<<END
    <tr>
        <td class=c1>{$ref->strExternalLink}</td>
        <td class=c1>$strPriceDisplay</td>
        <td class=c1>$strPercentageDisplay</td>
        <td class=c1>{$ref->strDate}</td>
        <td class=c1>{$ref->strTimeHM}</td>
        $strDisplayEx
    </tr>
END;
}

function _echoReferenceTableData($arRef, $callback, $bChinese)
{
    foreach ($arRef as $ref)
    {
       	_echoReferenceTableItem($ref, $bChinese, $callback);
        if ($callback == false)
        {
        	_echoReferenceTableItem($ref->extended_ref, $bChinese);
        }
    }
}

function EchoReferenceTable($arRef, $bChinese, $callback = false)
{
	$arColumn = GetReferenceTableColumn($bChinese);
	if ($callback)
	{
		$arColumnEx = call_user_func($callback, $bChinese);
        $strColumnEx = ' ';
		foreach ($arColumnEx as $str)
		{
            $strColumnEx .= GetTableColumn(90, $str);
		}
	}
	else
	{
		$strColumnEx = GetTableColumn(270, $arColumn[5]);
	}
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="reference">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=70 align=center>{$arColumn[1]}</td>
            <td class=c1 width=70 align=center>{$arColumn[2]}</td>
            <td class=c1 width=100 align=center>{$arColumn[3]}</td>
            <td class=c1 width=50 align=center>{$arColumn[4]}</td>
            $strColumnEx
        </tr>
END;

	_echoReferenceTableData($arRef, $callback, $bChinese);
    EchoTableEnd();
}

function EchoReferenceParagraph($arRef, $bChinese)
{
    if ($bChinese)     
    {
        $str = '参考数据';
    }
    else
    {
        $str = 'Reference data';
    }
    
    EchoParagraphBegin($str);
    EchoReferenceTable($arRef, $bChinese);
    EchoParagraphEnd();
}

?>
