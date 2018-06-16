<?php
require_once('stocktable.php');

// $ref from StockReference
function _echoReferenceTableItem($ref, $bChinese, $callback = false)
{
    if ($ref == false)	return;

    $strLink = $ref->GetExternalLink();
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
    	else					$strDescription = RefGetDescription($ref, $bChinese, true);
        $strDisplayEx = GetTableColumnDisplay($strDescription);
    }

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
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

function GetTimeDisplay()
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$ymd = new NowYMD();
	$strTick = strval($ymd->GetTick() * 1000);
	
	echo <<< END
	<script type="text/javascript">
		var now = new Date($strTick); 
		function UpdateTime() 
		{ 
			now.setTime(now.getTime() + 250); 
			document.getElementById("time").innerHTML = now.toLocaleTimeString(); 
		} 
		setInterval("UpdateTime()", 250);
	</script>
END;

	return '<span id="time"></span>';
}

function EchoReferenceParagraph($arRef, $bChinese, $str = false, $callback = false)
{
	if ($str == false)
	{
        $str = $bChinese ? '参考数据' : 'Reference data';
        $str .= ' '.GetTimeDisplay();
    }
    
	$arColumn = GetReferenceTableColumn($bChinese);
	$strId = 'reference';
	if ($callback)
	{
		$strId .= $callback;
		$arColumnEx = call_user_func($callback, $bChinese);
        $strColumnEx = ' ';
		foreach ($arColumnEx as $strColumn)
		{
            $strColumnEx .= GetTableColumn(90, $strColumn);
		}
	}
	else
	{
		$strColumnEx = GetTableColumn(270, $arColumn[5]);
	}
    
    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="$strId">
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
    EchoTableParagraphEnd();
}

?>
