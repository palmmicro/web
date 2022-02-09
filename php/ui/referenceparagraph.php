<?php
require_once('stocktable.php');

// $ref from StockReference
function _echoReferenceTableItem($ref)
{
	$ar = array();
   	$ar[] = $ref->GetExternalLink();
   	
    if ($ref->HasData())
    {
    	$ar[] = $ref->GetPriceDisplay();
    	$ar[] = $ref->GetPercentageDisplay();
    	$ar[] = $ref->GetDate();
    	$ar[] = $ref->GetTimeHM();
    }
    else
    {
    	$ar[] = '';
    	$ar[] = '';
    	$ar[] = '';
    	$ar[] = '';
    }
    
	$ar[] = RefGetDescription($ref, true);
    EchoTableColumn($ar);
}

function _echoReferenceTableData($arRef)
{
    foreach ($arRef as $ref)
    {
    	if ($ref)
    	{
    		_echoReferenceTableItem($ref);
   			if ($ref->extended_ref)	_echoReferenceTableItem($ref->extended_ref);
    	}
    }
}

function GetTimeDisplay()
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$ymd = GetNowYMD();
	$strTick = strval($ymd->GetTick() * 1000);
	
	echo <<< END
	<script>
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

function EchoReferenceParagraph($arRef, $str = false)
{
	if ($str == false)
	{
        $str = '参考数据 '.GetTimeDisplay();
    }

	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnPrice(),
								   new TableColumnChange(),
								   new TableColumnDate(),
								   new TableColumnTime(),
								   new TableColumnName()
								   ), 'reference', $str);

	_echoReferenceTableData($arRef);
    EchoTableParagraphEnd();
}

?>
