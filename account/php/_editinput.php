<?php
require_once('_account.php');
require_once('../php/externalurl.php');
require_once('../php/gb2312.php');
require_once('../php/iplookup.php');
require_once('../php/benfordimagefile.php');
require_once('../php/linearimagefile.php');
require_once('../php/tutorial/dice.php');
require_once('../php/tutorial/primenumber.php');	// require /php/sql/sqltable.php
require_once('../php/sql/sqlkeystring.php');
require_once('../php/ui/editinputform.php');
require_once('../php/ui/table.php');
require_once('../php/ui/imagedisp.php');

require_once('../php/stock.php');

function HexView($strInput)
{
	$str = '<br />Hex: ';
   	for ($i = 0; $i < strlen($strInput); $i++)
   	{
   		$iChar = ord($strInput[$i]);
   		$str .= sprintf('%02X, ', $iChar);
   	}
   	return rtrim($str, ', ');
}

function _getCommonPhraseString($strInput, $strMemberId, $bChinese)
{
	$sql = new CommonPhraseSql();
	if (empty($strInput) == false)
	{
		if ($sql->InsertString($strMemberId, $strInput))
		{
			trigger_error(ACCOUNT_TOOL_PHRASE_CN.' -- '.$strInput);
		}
	}
	
	$strConfirm = $bChinese ? '确认删除' : 'Confirm Delete';
	$str = '';
	if ($result = $sql->GetAll($strMemberId)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
			$strVal = $record['str'];
		    $str .= GetOnClickLink('/account/submitcommonphrase.php?delete='.$record['id'], $strConfirm.': '.$strVal.'?', $strVal).'<br />';
		}
		mysqli_free_result($result);
	}
	return $str;
}

function _getBenfordsLawString($strInput, $bChinese)
{
    $jpg = new BenfordImageFile();
    $jpg->Draw(explode(';', $strInput));
    return $jpg->GetAll($bChinese ? '总数' : 'Total');
}

function _getChiSquaredTestString($strInput, $bChinese)
{
	$ar = explode(';', $strInput);
	if (count($ar) == 2)
	{
		$strExpected = trim($ar[0]);
		$strObserved = trim($ar[1]);
		$str = ($bChinese ? '期望值' : 'Expected').': '.$strExpected;
		$str .= '<br />'.($bChinese ? '观察值' : 'Observed').': '.$strObserved;
		
		if ($f = PearsonChiSquaredTest(explode_float($strExpected), explode_float($strObserved)))
		{
			$str .= '<br />'.($bChinese ? '符合期望的概率' : 'P value').': '.strval_round($f);
		}
		else
		{
			$str .= '<br />'.($bChinese ? '无法计算' : 'Can not calculate');
		}
	}
	else
	{
		$str = '';
	}
	return $str;
}

function _getDiceCaptchaString($strInput, $bChinese)
{
	$ar = explode(';', $strInput);
	if (count($ar) == 2)
	{
		$strNum = trim($ar[0]);
		$strTarget = trim($ar[1]);
		$arDisplay = RobloxDice(intval($strNum), intval($strTarget));
		$strCount = strval(count($arDisplay));
		$arDisplay = array_unique($arDisplay);

		if ($bChinese)	$str = $strNum.'个骰子加起来等于'.$strTarget.'总共有'.$strCount.'种情况，排序合并后如下：';
		else				$str = $strNum.' dices adding up to '.$strTarget.' can appear in '.$strCount.' ways, here is the result after sorting and merging:';
		foreach ($arDisplay as $strDisplay)
		{
			$str .= '<br/>'.$strDisplay;
		}
		return $str;
	}
	return ($bChinese ? '数据格式不对' : 'Wrong data format');
}

function _getSimpleTestString($strInput, $bChinese)
{
	if (str_starts_with($strInput, 'http'))
	{
    	if ($str = url_get_contents($strInput))
    	{
    		if ($ar = json_decode($str, true))		DebugPrint($ar);
    		$strFileName = DebugGetPathName('simpletest.txt');
    		file_put_contents($strFileName, $str);
    		DebugString('Saved '.$strInput.' to '.$strFileName);
    		$str = GetFileDebugLink($strFileName);
    	}
    	else	$str = $bChinese ? 'Curl读错误' : 'Curl read error';
	}
	else
	{
    	$str = is_numeric($strInput) ? DebugGetDateTime($strInput) : urldecode($strInput);
    	$str .= HexView($strInput);
    }
    return $str;
}

function _getPercentage($ar, $i, $iGap, $bSameDay)
{
	if (!$bSameDay)	$i --;
	return strval(floatval($ar[$i]) / floatval($ar[$i + $iGap]) - 1.0);
}

function _getArrayDisplay($ar, $strSeparator, $strNewLine, $iCol = 10)
{
	$str = '';
	$iTotal = count($ar);
	for ($i = 0; $i < $iTotal; $i += $iCol)
	{
		for ($j = 0; $j < $iCol; $j ++)
		{
			if ($i + $j < $iTotal)	$str .= mysql_round($ar[$i + $j], 4).$strSeparator;
			else						break;
		}
		$str .= $strNewLine;
    }
    return rtrim($str, $strSeparator.$strNewLine);
}

function _getLinearRegressionStockArrays(&$arX, &$arY, $strInput, $strSeparator, $strNewLine)
{
	$iGap = 20;
//	$iGap = 1;
	$iTotal = 400 + $iGap + 1;

    $arRef = array();
	foreach (StockGetSymbolArray($strInput) as $strSymbol)
	{
		$ref = new MyStockReference($strSymbol);
		if ($ref->HasData())
		{
			UpdateYahooHistoryChart($ref);
			$arRef[] = $ref;
		}
	}
	if (count($arRef) != 2)	return '';
	
	$arCloseX = array();
	$arCloseY = array();
	$x_ref = $arRef[0];
	$y_ref = $arRef[1];
	$strStockIdY = $y_ref->GetStockId();
	$his_sql = GetStockHistorySql();
	$iCount = 0;
    if ($result = $his_sql->GetAll($x_ref->GetStockId()))
   	{
   		while ($record = mysqli_fetch_assoc($result)) 
   		{
   			if ($strY = $his_sql->GetAdjClose($strStockIdY, $record['date'], true))
   			{
   				$strX = rtrim0($record['adjclose']);
   				if (!IsZeroString($strX) && !IsZeroString($strY))
   				{
   					$arCloseX[] = $strX;
   					$arCloseY[] = $strY;
   					$iCount ++;
   					if ($iCount == $iTotal)	break;
   				}
   			}
		}
		mysqli_free_result($result);
	}

//	$bSameDayX = true;
//	$bSameDayY = true;
	$bSameDayX = UseSameDayNav($x_ref);
	$bSameDayY = UseSameDayNav($y_ref);
	$iStart = ($bSameDayX && $bSameDayY) ? 0 : 1;
	for ($i = $iStart; $i < $iTotal - $iGap + $iStart - 1; $i += $iGap)
	{
		$arX[] = _getPercentage($arCloseX, $i, $iGap, $bSameDayX);
		$arY[] = _getPercentage($arCloseY, $i, $iGap, $bSameDayY);
	}
	
  	$str = GetStockHistoryLink($x_ref->GetSymbol(), 'x').' = {';
  	$str .= _getArrayDisplay($arX, $strSeparator, $strNewLine);
    $str .= '}'.$strNewLine.GetStockHistoryLink($y_ref->GetSymbol(), 'y').' = {';
  	$str .= _getArrayDisplay($arY, $strSeparator, $strNewLine);
   	$str .= '}';
	return $str;
}

function _getLinearRegressionArrays(&$arX, &$arY, $strInput, $strSeparator, $strNewLine, $strFunction)
{
	$fCount = 0.0;
	$ar = explode(';', $strInput);
	foreach ($ar as $str)
	{
		$str = trim($str);
		$arXY = explode(',', $str);
		if (count($arXY) == 2)
		{
			$fX = floatval($arXY[0]);
			$fCount = $fX;
			$fY = floatval($arXY[1]);
		}
		else
		{
			$fX = $fCount;
			$fY = floatval($str);
		}
		$fCount += 1.0;
		
		$arX[] = $fX;
		$arY[] = empty($strFunction) ? $fY : call_user_func($strFunction, $fY);
	}
	
    $str = 'x = {'.implode($strSeparator, $arX).'}';
    $str .= $strNewLine.'y = {'.(empty($strFunction) ? implode($strSeparator, $arY) : strval_round_implode($arY, $strSeparator)).'}';
	return $str;
}

function _getLinearRegressionString($strInput, $bChinese)
{
	$arX = array();
	$arY = array();
	
	if ($strFunction = strstr($strInput, '(', true))
	{
		$strInput = ltrim($strInput, $strFunction.'(');
		$strInput = rtrim($strInput, ')');
	}

   	$strNewLine = GetBreakElement();
   	$strSeparator = ', ';
	if ($strFunction == 'stock')		$str = _getLinearRegressionStockArrays($arX, $arY, $strInput, $strSeparator, $strNewLine);
	else								$str = _getLinearRegressionArrays($arX, $arY, $strInput, $strSeparator, $strNewLine, $strFunction);

    $jpg = new LinearImageFile();
    if ($jpg->Draw($arX, $arY))
    {
//    	if ($strFunction == 'stock')		$str .= $strNewLine.($bChinese ? '皮尔逊相关系数：' : 'Pearson correlation coefficient: ').PearsonCorrelation($arX, $arY);
    	$str .= $strNewLine.$strNewLine.GetBoldElement($jpg->GetEquation());
    	$str .= $strNewLine.$jpg->GetLink();
    	return $str;
    }
	return ($bChinese ? '数据不足' : 'Not enough data');
}

function _getLinearEquationString($strA, $strB, $strC)
{
	return $strA.' * x + '.$strB.' * y = '.$strC;
}

function _getCramersLawString($strInput, $bChinese)
{
	$ar = explode(';', $strInput);
	if (count($ar) == 2)
	{
		list($strA1, $strB1, $strC1) = explode(',', trim($ar[0]));
		list($strA2, $strB2, $strC2) = explode(',', trim($ar[1]));
		$str = _getLinearEquationString($strA1, $strB1, $strC1);
		$str .= '<br />'._getLinearEquationString($strA2, $strB2, $strC2);
		
		if ($arXY = CramersRule(floatval($strA1), floatval($strB1), floatval($strC1), floatval($strA2), floatval($strB2), floatval($strC2)))
		{
			list($fX, $fY) = $arXY;
			$str .= '<br /><br /><b>x = '.strval_round($fX);
			$str .= '; y = '.strval_round($fY).'</b>';
		}
		else
		{
			$str .= '<br />'.($bChinese ? '无解' : 'No solution');
		}
	}
	else
	{
		$str = '';
	}
	return $str;
}

function _getPrimeNumber($callback, $strNumber)
{
    $fStart = microtime(true);
    $aiNum = call_user_func($callback, intval($strNumber));
	$str = $strNumber.'=';
	foreach ($aiNum as $iPrime)
	{
		$str .= strval($iPrime).'*';
	}
	return rtrim($str, '*').DebugGetStopWatchDisplay($fStart, 4);
}

function _getPrimeNumberString($strNumber, $bChinese)
{
	$str = $bChinese ? '直接野蛮算' : 'Direct Computation';
	$str .= ': '._getPrimeNumber('OnePassPrimeNumber', $strNumber).'<br />';
	$str .= $bChinese ? '数据库查找' : 'Database Lookup';
	$str .= ': '._getPrimeNumber('LookUpPrimeNumber', $strNumber);
	return $str;
}

function _getSinaJsChineseStockArray($bChinese)
{
	if ($bChinese)	return	 array('GB2312编码的股票名字', STOCK_DISP_OPEN, '昨日收盘价', '当前价格，收盘后数据可以当成今日收盘价？', STOCK_DISP_HIGH, STOCK_DISP_LOW, '当前买价，跟序号11买一字段相同。', '当前卖价，跟序号21卖一字段相同。', STOCK_DISP_QUANTITY, '总成交金额', 
										'买一股数', '买一价格，跟序号6相同。', '二', '二', '三', '三', '四', '四', '五', '五', '卖一股数', '卖一价格，跟序号7相同。', '二', '二', '三', '三', '四', '四', '五', '五', '日期', '时间', '结束符？');
	return	 array('GB2312 coded stock name', 'Today open', 'Last close', 'Current price, used as today close after market close?', 'Today high', 'Today low', 'Current bid, same as index 11 bid1.', 'Current ask, same as index 21 ask1.', 'Total quantity', 'Total amount', 
					'Bid1 quantity', 'Bid1 price, same as index 6.', '2', '2', '3', '3', '4', '4', '5', '5', 'Ask1 quantity', 'Ask1 price, same as index 7.', '2', '2', '3', '3', '4', '4', '5', '5', 'Date', 'Time', 'End of data?');
}

function _getSinaJsFundArray($bChinese)
{
	if ($bChinese)	return	 array('GB2312编码的名字', '目前净值', '累计净值', '昨日净值', '日期', '？');
	return	 array('GB2312 coded name', 'Current net value', 'Accumulated net value', 'Previous net value', 'Date', '?');
}

function _getSinaJsAmericanArray($bChinese)
{
	if ($bChinese)	return	 array('GB2312编码的中文名字', '当前价格，收盘后数据可以当成今日收盘价？', '相对昨日收盘价的变化百分比', '中国时区日期和时间', '相对昨日收盘价的变化', STOCK_DISP_OPEN, STOCK_DISP_HIGH, STOCK_DISP_LOW, '52周'.STOCK_DISP_HIGH, '52周'.STOCK_DISP_LOW, 
										STOCK_DISP_QUANTITY, '10日均量', '市值', '每股收益', '市盈率', '？', '贝塔系数', '股息', '收益率', '股本', '？', '盘前盘后交易', '盘前盘后交易变化百分比', '盘前盘后交易变化', '美东时区盘前盘后交易日期和时间',
										'美东时区日期和时间', '昨日收盘价', '盘前盘后交易'.STOCK_DISP_QUANTITY, '未知，从此项开始以下为2020年9月22日新增。', '年份，可能是为了24和25项在年末时用strtotime函数会搞错年份而加。', '总成交金额，除以第10项换算成当日均价后跟雪球显示的不一致。');
	return	 array('GB2312 coded Chinese name', 'Current price, used as today close after market close?', '% Change from last close', 'PRC date time', 'Change from last close', 'Open price', 'Today high', 'Today low', '52 weeks high', '52 weeks low', 
										'Total quantity', '10 days average quantity', 'Market value', 'EPS', 'PE', '?', 'Beta', 'Dividends', 'Rate of return', 'Share capital', '?', 'Extended trading', 'Extended trading % change', 'Extended trading change', 'EDT extended trading date time',
										'EDT date time', 'Last close', 'Extended trading quantity', '?', 'Year', 'Total amount');
}

function _getSinaJsFutureArray($bChinese)
{
	if ($bChinese)	return	 array('当前价格', '相对昨日结算价的变化百分比', '当前买价', '当前卖价', STOCK_DISP_HIGH, STOCK_DISP_LOW, '时间', '昨日结算价', STOCK_DISP_OPEN, '持仓量', '当前买量？', '当前卖量？', '日期', 'GB2312编码的名字');
	return	 array('Current price', 'The percentage of current price change', 'Bid price', 'Ask price', 'Today high', 'Today low', 'Time', 'Last adjusted close', 'Open price', 'Volume', 'Bid quantity?', 'Ask quantity?', 'Date', 'GB2312 coded name');
}

function _getSinaJsHongkongArray($bChinese)
{
	if ($bChinese)	return	 array('英文名字', 'GB2312编码的中文名字', STOCK_DISP_OPEN, '昨日收盘价', STOCK_DISP_HIGH, STOCK_DISP_LOW, '当前价格，收盘后数据可以当成今日收盘价？', '相对昨日收盘价的变化', '相对昨日收盘价的变化百分比', '当前买价？', '当前卖价？', '总成交金额', STOCK_DISP_QUANTITY, 
										'市盈率？', '周息率？', '52周'.STOCK_DISP_HIGH, '52周'.STOCK_DISP_LOW, '日期', '时间');
	return	 array('English name', 'GB2312 coded Chinese name', 'Open price', 'Last close', 'Today high', 'Today low', 'Current price, used as today close after market close?', 'Change from last close', '% Change from last close', 'Bid price?', 'Ask price?', 'Total amount', 'Total quantity', 
					'PE?', 'Interest rate?', '52 weeks high', '52 weeks low', 'Date', 'Time');
}

function _getSinaJsChineseFutureArray($bChinese)
{
	if ($bChinese)	return	 array('名字', '时间HH:MM:SS', STOCK_DISP_OPEN, STOCK_DISP_HIGH, STOCK_DISP_LOW, '昨日收盘价', '买价', '卖价', '最新价', '结算价', '昨日结算价', '买量', '卖量', '持仓量', STOCK_DISP_QUANTITY, '商品交易所简称', '品种名简称', '日期');
	return	 array('Name', 'Time HH:MM:SS', 'Open price', 'Today high', 'Today low', 'Last close', 'Bid', 'Ask', 'Current price', 'Adjusted close', 'Last adjusted close', 'Bid quantity', 'Ask quantity', 'Volume', 'Total quantity', 'Exchange short name', 'Short name', 'Date');
}

// var hq_str_sz164906="中国互联" ==> sz164906;
function _getSinaSymbol($strFirst)
{
	$str = str_replace('var hq_str_', '', $strFirst);
	$iEqualsIndex = strpos($str, '=');
	if ($iEqualsIndex !== false)	$str = substr($str, 0, $iEqualsIndex);
//	DebugString($str);
	return $str;
}

function _getSinaJsInterpretationArray($strSymbol, $bChinese)
{
	if (preg_match('/^(sh|sz|bj)\d{6}$/', $strSymbol))					return _getSinaJsChineseStockArray($bChinese);
	else if (preg_match('/^'.SINA_FUND_PREFIX.'\d{6}$/', $strSymbol))	return _getSinaJsFundArray($bChinese);
	else if (str_starts_with($strSymbol, SINA_US_PREFIX))				return _getSinaJsAmericanArray($bChinese);
	else if (str_starts_with($strSymbol, SINA_FUTURE_PREFIX))			return _getSinaJsFutureArray($bChinese);
	else if (str_starts_with($strSymbol, SINA_HK_PREFIX))				return _getSinaJsHongkongArray($bChinese);	// rt_hkHSCEI, rt_hk00386
	else if (str_ends_with($strSymbol, '0'))								return _getSinaJsChineseFutureArray($bChinese);
	return false;
}

function _getSinaJsString($strInput, $bChinese)
{
    if ($str = url_get_contents(GetSinaDataUrl($strInput), UrlGetRefererHeader(GetSinaFinanceUrl())))
    {
    	$arLine = explode("\n", $str);
    	$str = '';
    	$strNewLine = GetBreakElement();
    	foreach ($arLine as $strLine)
    	{
    		if ($strLine != '')
    		{
    			$iCount = 0;
    			$arItem = explode(',', $strLine);
    			$strSymbol = _getSinaSymbol($arItem[0]);
    			$strFileName = DebugGetSinaFileName($strSymbol);
		        file_put_contents($strFileName, $strLine);
    			$str .= GetFileLink($strFileName, true).$strNewLine;
    			$arMeaning = _getSinaJsInterpretationArray($strSymbol, $bChinese);
	    		foreach ($arItem as $strItem)
	    		{
	    			$str .= GetRemarkElement(strval($iCount)).': ';
	    			if ($strItem == '')	$str .= '('.($bChinese ? '空' : 'Empty').')';
	    			else					$str .= GetQuoteElement(GbToUtf8($strItem));
					if ($arMeaning && isset($arMeaning[$iCount]))	$str .= ' ==> '.GetInfoElement($arMeaning[$iCount]);
	    			$str .= $strNewLine;
	    			$iCount ++;
	    		}
	    		$str .= $strNewLine;
	    	}
	    }
    	return $str;
    }
    return 'curl'.($bChinese ? '失败' : ' failed');
}

function _getTaobaoDouble11Data()
{
	return '0.5; 9.36; 52; 191; 352; 571; 912; 1207; 1682.69; 2135; 2684';
}

function _getTaobaoDouble11SqrtData()
{
	return 'sqrt('._getTaobaoDouble11Data().')';
}

function _getTaobaoSalesData()
{
	return '66.7; 119; 200; 345; 525; 762; 1011; 1583; 2503; 3768';
}

function _getTaobaoSalesLogData()
{
	return 'log('._getTaobaoSalesData().')';
}

function _echoBenfordsLawRelated()
{
	$strTaobao = GetQuoteElement(_getTaobaoDouble11Data());
	$strTaobaoSales = GetQuoteElement(_getTaobaoSalesData());

	$strBaba = GetMyStockLink('BABA');
	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li>淘宝天猫从2009年开始双11交易额(亿元): $strTaobao</li>
	    <li>阿里{$strBaba}从2010年开始财报中的总销售额(亿元): $strTaobaoSales</li>
    </ol>
END;
}

function _echoLinearRegressionRelated()
{
	$strTaobaoSqrt = GetQuoteElement(_getTaobaoDouble11SqrtData());
	$strTaobaoLog = GetQuoteElement(_getTaobaoSalesLogData());
	$strBenford = GetQuoteElement('1,'.GetStandardBenfordData());
	$strStockHistory = GetQuoteElement('stock(600028,00386)');

	$strSZ162411 = GetGroupStockLink('SZ162411', true);	
	$strBaba = GetMyStockLink('BABA');
	$strSH600028 = GetMyStockLink('SH600028');
	$str00386 = GetMyStockLink('00386');
	echo <<< END
	<p>测试数据:</p>
	<ol>
	    <li>{$strSZ162411}2019年8月16日到22日场内溢价百分比x和场内申购账户数y: <font color=gray>1.02,5069; 0.51,3081; 2.92,6936; 3.47,7846; 2.07,5583</font></li>
	    <li>淘宝天猫从x=0(2009年)开始双11交易额y(亿元): $strTaobaoSqrt</li>
	    <li>阿里{$strBaba}历年x=0(2010年)财报中的总销售额y(亿元): $strTaobaoLog</li>
	    <li>本福特标准分布: $strBenford</li>
	    <li>{$strSH600028}和{$str00386}股票价格相关程度: $strStockHistory</li>
    </ol>
END;
}

function _echoInputRelated($strPage, $bChinese)
{
    switch ($strPage)
    {
   	case 'benfordslaw':
   		if ($bChinese)	_echoBenfordsLawRelated();
   		break;
   		
   	case 'linearregression':
   		if ($bChinese)	_echoLinearRegressionRelated();
    	break;
   	}
}

function _echoInputResult($acct, $strPage, $strInput, $bChinese)
{
    switch ($strPage)
    {
   	case 'benfordslaw':
   		$str = _getBenfordsLawString($strInput, $bChinese);
   		break;
    		
    case 'chisquaredtest':
    	$str = _getChiSquaredTestString($strInput, $bChinese);
    	break;
    	
    case 'commonphrase':
    	$str = _getCommonPhraseString($strInput, $acct->GetLoginId(), $bChinese);
    	break;
    		
   	case 'cramersrule':
    	$str = _getCramersLawString($strInput, $bChinese);
    	break;
    	
    case 'dicecaptcha':
    	$str = _getDiceCaptchaString($strInput, $bChinese);
    	break;
    	
    case 'simpletest':
    	$str = _getSimpleTestString($strInput, $bChinese);
    	break;
    		
    case 'ip':
		if (filter_valid_ip($strInput))
		{
			$sql = $acct->GetIpSql();
			$sql->InsertIp($strInput);
			$str = $acct->IpLookupString($strInput, $bChinese);
		}
		else
		{
			$str = $bChinese ? '无效IP地址' : 'Invalid IP Address';
		}
    	break;
    	
   	case 'linearregression':
    	$str = _getLinearRegressionString($strInput, $bChinese);
    	break;
    	
    case 'primenumber':
    	$str = _getPrimeNumberString($strInput, $bChinese);
    	break;
    	
   	case 'sinajs':
    	$str = _getSinaJsString($strInput, $bChinese);
    	break;
    }
    
    $str .= ImgAccountTool($strPage);
    EchoParagraph($str);
}

function _getDefaultInput($strPage)
{
   	switch ($strPage)
   	{
   	case 'benfordslaw':
   		$str = _getTaobaoDouble11Data();
   		break;
    		
   	case 'chisquaredtest':
   		$str = '200,200,200,200,200,200; 215,210,185,195,190,205';
// 		$strInput = '164,96,68,53,43,36,32,28,25; 168,97,64,55,39,29,30,37,25';
   		break;
    		
   	case 'commonphrase':
   		$str = '';
    	break;
    		
    case 'cramersrule':
    	$str = '0.2506,2.487,1099; 2.450,2.557,7408';
    	break;
    		
    case 'dicecaptcha':
    	$str = '4; 14';
    	break;
    	
   	case 'ip':
   		$str = UrlGetIp();
    	break;
    		
    case 'linearregression':
//  	$strInput = '1.02,5069; 0.51,3081; 2.92,6936; 3.47,7846; 2.07,5583';
    	$str = _getTaobaoDouble11SqrtData();
    	break;
    		
   	case 'sinajs':
    	$str = 'sz162411,f_162411,gb_xop,hf_CL,rt_hk00386,AU0,b_TPX,rt_hkHSIII';
   		break;
   		
    default:
    	$str = strval(GetNowTick());
    	break;
    }
    return $str;
}

function EchoAll($bChinese = true)
{
	global $acct;
	
	$strPage = $acct->GetPage();
    if (isset($_POST['clear']))
	{
		unset($_POST['clear']);
		$strInput = '';
	}
	else if (isset($_POST['submit']) && isset($_POST[EDIT_INPUT_NAME]))
	{
		unset($_POST['submit']);
		$strInput = SqlCleanString($_POST[EDIT_INPUT_NAME]);
	}
	else if ($strInput = $acct->GetQuery())	
	{
	}
    else
    {
    	$strInput = _getDefaultInput($strPage);
    }
    
    EchoEditInputForm(GetAccountToolStr($strPage, $bChinese), $strInput, $bChinese);
    _echoInputResult($acct, $strPage, $strInput, $bChinese);
    _echoInputRelated($strPage, $bChinese);

	$str = GetAccountToolLinks($bChinese);
	if ($bChinese)	$str .= ' '.GetDevLink('entertainment/20100905cn.php#'.$strPage).'<br />'.GetStockMenuLinks();
    EchoParagraph($str);
}

function _getAccountToolTitle($strPage, $strQuery, $bChinese)
{
	$str = GetAccountToolStr($strPage, $bChinese);
	if ($strQuery)
	{
		if ($bChinese == false)	$str .= ' ';
		$str .= $strQuery; 
	}
	return $str;
}

function GetMetaDescription($bChinese = true)
{
	global $acct;
	
	$strPage = $acct->GetPage();
  	$str = _getAccountToolTitle($strPage, $acct->GetQuery(), $bChinese);
  	switch ($strPage)
  	{
   	case 'benfordslaw':
  		$str .= $bChinese ? '页面. 用Benford定律检验数据是否造假, 画出实际数字出现的概率分布和理论概率分布的比较图. 最后用卡方检验(Pearson\'s Chi-squared Test)统一结果.'
    						: ' page, testing data using Benford\'s law, draw compare images, and run Pearson\'s Chi-squared Test in the end.';
   		break;
    		
    case 'chisquaredtest':
  		$str .= $bChinese ? '(Chi-squared Test)用来统计样本的实际观测值与理论推断值之间的偏离程度. 卡方值为0表明观测值与理论值完全符合.'
    						: ' to determine whether there is a significant difference between the expected frequencies and the observed frequencies.';
  		break;
  		
  	case 'commonphrase':
  		$str .= $bChinese ? '页面. 输入, 显示, 修改和删除个人常用短语. 用在股票交易记录等处, 方便快速输入和修改个人评论. 限制每条短语最长32个字, 每个用户最多20条短语.'
    						: ' page, input, display, edit and delete personal common phrases, used in places like stock transaction records.';
  		break;
  		
   	case 'cramersrule':
  		$str .= $bChinese ? '计算页面。Cramer法则求解方程组 a1 * X + b1 * Y = c1; a2 * X + b2 * Y = c2; 附带算法步骤图作为参考。'
    						: ' calculation, use Cramer\'s rule to solve a linear system of 2x2 equations, together with algorithm steps image.';
  		break;
  		
    case 'dicecaptcha':
  		$str .= $bChinese ? '分析页面. 为罗布乐思Roblox变态的验证码提供思路, 看看4个骰子加起来等于14到底有多少种可能的数字排列方式. '
    						: ' page, try to list all possible ways 4 dices adding up is 14, to solve the impossible Roblox verification.';
    	break;
    	
  	case 'simpletest':
  		$str .= $bChinese ? '页面. 测试代码暂时放在/account/_editinput.php中, 测试成熟后再分配具体长期使用的工具页面. 不成功的测试就可以直接放弃了.'
    						: ' page, testing source code in /account/_editinput.php first. Functions will be moved to permanent pages after test.';
  		break;
  		
  	case 'ip':
  		$str .= $bChinese ? '查询页面. 从ipinfo.io等网站查询IP地址对应的国家, 城市, 网络运营商和公司等信息. 同时也从palmmicro.com的用户登录和评论中提取对应记录.'
    						: ' page, display country, city, service provider and company information from ipinfo.io.';
  		break;
  		
   	case 'linearregression':
  		$str .= $bChinese ? '计算页面. 通过最小二乘法计算出结果为 Y = A + B * X 的直线和相关系数R, 并且显示出原始数据点和计算结果直线示意图. 附带算法步骤图作为参考. '
    						: ' calculation, display the Y = A + B * X result and correlation coefficient R, together with algorithm steps image.';
  		break;
  		
  	case 'primenumber':
  		$str .= $bChinese ? '页面。质数又称素数，该数除了1和它本身以外不再有其他的因数，否则称为合数。每个合数都可以写成几个质数相乘的形式。其中每个质数都是这个合数的因数，叫做这个合数的'.ACCOUNT_TOOL_PRIME_CN.'。'
    						: ' page. A prime number (or a prime) is a natural number greater than 1 that has no positive divisors other than 1 and itself.';	//  A natural number greater than 1 that is not a prime number is called a composite number
    	break;
    	
   	case 'sinajs':
  		$str .= $bChinese ? '查询页面。在新浪股票数据接口加上Referer验证后提供一个可以直观看到查询结果的地方，同时为日后的新验证测试做好准备。'
    						: ' page, provide a direct display after Referer verification added to Sina stock data interface.';
  		break;
    }
    return CheckMetaDescription($str);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strPage = $acct->GetPage();
	return _getAccountToolTitle($strPage, $acct->GetQuery(), $bChinese);
}

	$acct = new IpLookupAccount(false, array('commonphrase', 'ip', 'sinajs'));
?>
