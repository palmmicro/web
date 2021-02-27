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
    }
    return $ar;
}

function _botGetStockText($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $str = false;
    if ($sym->IsSinaFund())     
    {   // IsSinaFund must be called before IsSinaFuture
        $ref = new FundReference($strSymbol);
        $str = TextFromFundReference($ref); 
    }
    else if ($sym->IsSinaFuture())
    {
        $ref = new FutureReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsSinaForex())
    {
    	$ref = new ForexReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsEastMoneyForex())
    {
    	$ref = new CnyReference($strSymbol);
        $str = TextFromStockReference($ref); 
    }
    else if ($sym->IsFundA())
    {
        $ref = StockGetFundReference($strSymbol);
        $str = TextFromFundReference($ref);
        if (in_arrayQdii($strSymbol))
        {
	        $str .= BOT_EOL.TextFromStockReference($ref->GetCnyRef()); 
	        $str .= BOT_EOL.TextFromStockReference($ref->GetEstRef()); 
	        if ($future_ref = $ref->GetFutureRef())		$str .= BOT_EOL.TextFromStockReference($future_ref); 
	    }
    }
    else
    {
       	$ref = new MyStockReference($strSymbol);
       	$str = TextFromStockReference($ref);
       	
    	$ab_sql = new AbPairSql();
    	if ($ab_sql->GetPairSymbol($strSymbol))
    	{
    		$ab_ref = new AbPairReference($strSymbol);
			$str .= TextFromAbReference($ab_ref);
    	}
    	else if ($strSymbolA = $ab_sql->GetSymbol($strSymbol))
    	{
    		$ab_ref = new AbPairReference($strSymbolA);
			$str .= TextFromAbReference($ab_ref, false);
    	}
    	
    	if ($ref_ar = StockGetHShareReference($sym))
    	{
    		list($dummy, $hshare_ref) = $ref_ar;
			$str .= TextFromAhReference($hshare_ref);
    	}
    }
   	if ($str == false)
   	{
   		DebugString("($strSymbol:无数据)");
   		return false;
   	}
   	
/*
	if ($strSymbol == 'SZ162411')
	{
		$str .= '2019年9月20日星期五, XOP季度分红除权. 因为现在采用XOP净值替代SPSIOP做华宝油气估值, 23日的估值不准, 要等华宝油气20日实际净值出来自动校准后恢复正常.'.BOT_EOL;
	}*/
    return $str;
}

function _botGetStockArrayText($arSymbol, $str, $strVersion)
{
	$iMaxLen = MAX_BOT_MSG_LEN - strlen($strVersion);
	StockPrefetchArrayData($arSymbol);
		
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
		else
		{	// something is wrong, break to avoid timeout
			break;
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
	$strText = str_replace(',', '', $strText);
	$strText = str_replace('。', '', $strText);
	$strText = str_replace('.', '', $strText);
	$strText = trim($strText);
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
