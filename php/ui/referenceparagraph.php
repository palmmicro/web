<?php
require_once('stocktable.php');

// $ref from StockReference
function _echoReferenceTableItem($ref, $bAdmin)
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
    
	$ar[] = $bAdmin ? $ref->DebugLink() : RefGetDescription($ref, true);
    EchoTableColumn($ar, false, ($bAdmin ? RefGetDescription($ref) : false));
}

function _echoReferenceTableData($arRef, $bAdmin)
{
    foreach ($arRef as $ref)
    {
    	if ($ref)
    	{
    		_echoReferenceTableItem($ref, $bAdmin);
   			if ($ref->extended_ref)	_echoReferenceTableItem($ref->extended_ref, false);
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

function EchoReferenceParagraph($arRef, $bAdmin = false)
{
	$str = '参考数据 '.GetTimeDisplay();
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnPrice(),
								   new TableColumnChange(),
								   new TableColumnDate(),
								   new TableColumnTime(),
								   new TableColumnName()
								   ), 'reference', $str);

	_echoReferenceTableData($arRef, $bAdmin);
    EchoTableParagraphEnd();
}

?>
