<?php
require_once('stock.php');
require_once('ui/stocktext.php');

define('MAX_BOT_STOCK', 32);

function _botGetStockArray($strKey)
{
	$sql = GetStockSql();
    $ar = array();
    
//  if (!empty($strKey))     // "0" (0 as a string) is considered to be empty
	$iLen = strlen($strKey); 
    if ($iLen > 0)
    {
/*    	$bPinYin = false;
    	if ($iLen == 4)
    	{
    		if (preg_match('#[A-Za-z]+#', $strKey))
    		{
    			DebugString('拼音简称:'.$strKey);
    			$gb_sql = new GB2312Sql();
    			$bPinYin = true;
    		}
    	}
*/

//    	$fStart = microtime(true);
/*    	if ($result = $sql->GetData("symbol LIKE '%$strKey%' OR name LIKE '%$strKey%'", 'symbol ASC', strval(MAX_BOT_STOCK))) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ar[] = $record['symbol'];
    		}
    		@mysql_free_result($result);
    	}
*/    	
    	if ($result = $sql->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strSymbol = $record['symbol'];
    			$strName = $record['name'];
    			if ((stripos($strSymbol, $strKey) !== false) 
    				|| (stripos($strName, $strKey) !== false)
//    				|| ($bPinYin && (stripos($gb_sql->GetStockPinYinName($strName), $strKey) !== false))
    				)
    			{
    				$ar[] = $strSymbol;
    				if (count($ar) >= MAX_BOT_STOCK)	
    					break;
    			}
    		}
    		@mysql_free_result($result);
    	}
//    	DebugString($strKey.':'.DebugGetStopWatchDisplay($fStart));
    }
    return $ar;
}

function _botGetStockText($strSymbol)
{
    $str = false;
	$ref = StockGetReference($strSymbol);
    if ($ref->IsFundA())
    {
    	if (in_arrayQdiiMix($strSymbol))
    	{
    		$holdings_ref = new HoldingsReference($strSymbol);
    		$str = TextFromHoldingsReference($holdings_ref);
//   			$str .= BOT_EOL.TextFromStockReference($holdings_ref->GetUscnyRef()); 
//   			$str .= BOT_EOL.TextFromStockReference($holdings_ref->GetHkcnyRef()); 
    	}
    	else
    	{
    		$fund_ref = StockGetFundReference($strSymbol);
    		$str = TextFromFundReference($fund_ref);
    		if (in_arrayQdii($strSymbol) || in_arrayQdiiHk($strSymbol))
    		{
//    			$str .= BOT_EOL.TextFromStockReference($fund_ref->GetCnyRef()); 
    			$str .= BOT_EOL.TextFromStockReference($fund_ref->GetEstRef()); 
    			if ($future_ref = $fund_ref->GetFutureRef())	$str .= BOT_EOL.TextFromStockReference($future_ref);
    		}
	    }
    }
    else
    {
		if ($str = TextFromStockReference($ref))
		{
			list($ab_ref, $ah_ref, $adr_ref) = StockGetPairReferences($strSymbol);
			$str .= TextPairRatio($ab_ref, STOCK_DISP_ASHARES, STOCK_DISP_BSHARES, 'A/B');  
			$str .= TextPairRatio($ah_ref, STOCK_DISP_ASHARES, STOCK_DISP_HSHARES, 'A/H');  
			$str .= TextPairRatio($adr_ref, 'ADR', STOCK_DISP_HSHARES, 'ADR/H');
		}
    }
    
   	if ($str == false)
   	{
   		$str = "($strSymbol:无数据)";
   		DebugString($str);
		$str .= BOT_EOL;
   	}
   	
    return $str;
}

function _botGetStockArrayText($arSymbol, $str, $strVersion)
{
	$iMaxLen = MAX_BOT_MSG_LEN - strlen($strVersion);
	StockPrefetchArrayExtendedData($arSymbol);
		
	foreach ($arSymbol as $strSymbol)
	{
		if ($strText = _botGetStockText($strSymbol))
		{
			if (strlen($str.$strText.BOT_EOL) < $iMaxLen)
			{
				$str .= $strText.BOT_EOL;
			}
			else
			{
				break;
			}
		}
	}
	return $str;
}

function StockBotGetStr($strText, $strVersion)
{
	InitGlobalStockSql();
	
	$strText = str_replace('【', '', $strText);
	$strText = str_replace('】', '', $strText);
	$strText = str_replace('，', '', $strText);
	$strText = str_replace('。', '', $strText);
	$strText = str_replace_utf8_space($strText);		// &nbsp;
	$strText = trim($strText, " ,.\n\r\t\v\0");
	$strText = SqlCleanString($strText);

	$arSymbol = _botGetStockArray($strText);
	if ($iCount = count($arSymbol))
	{
		if ($iCount > 1)
		{
			$str = '(至少发现'.strval($iCount).'个匹配：';
			foreach ($arSymbol as $strSymbol)	$str .= $strSymbol.' ';
			$str = rtrim($str, ' ');
			$str .= ')'.BOT_EOL.BOT_EOL;
		}
		else
		{
			$str = '';
		}
		return _botGetStockArrayText($arSymbol, $str, $strVersion);
	}
	return false;
}

?>
