<?php

function _chinaMoneyNeedData($strDate, $nav_sql, $strUscnyId, $strHkcnyId)
{
    if ($nav_sql->GetRecord($strUscnyId, $strDate) && $nav_sql->GetRecord($strHkcnyId, $strDate))
    {
//    	DebugString('Database entry existed');
    	return false;
    }
    return $strDate;
}

function ChinaMoneyGetUrl()
{
	return 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/data/fx/ccpr.json';
// 	return 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/html/cn/latestRMBParityCn.html';
}

function GetChinaMoney($ref)
{
	$nav_sql = GetNavHistorySql();
    $strUscnyId = SqlGetStockId('USCNY');
    $strHkcnyId = SqlGetStockId('HKCNY');
    if (_chinaMoneyNeedData($ref->GetDate(), $nav_sql, $strUscnyId, $strHkcnyId) == false)		return;
	if ($ref->GetHourMinute() < 915)																		return;	// Data not updated until 9:15
    
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$strFileName = DebugGetChinaMoneyFile();
	if (StockNeedFile($strFileName) == false)															return; 	// updates on every minute
	
   	if ($str = url_get_contents(ChinaMoneyGetUrl()))
   	{
   		DebugString($strFileName.': Save new file');
   		file_put_contents($strFileName, $str);
   	}
   	else																									return;
	
	$ar = json_decode($str, true);
    $arData = $ar['data'];
    $strDate = _chinaMoneyNeedData(substr($arData['lastDate'], 0, 10), $nav_sql, $strUscnyId, $strHkcnyId);		// 2018-04-12 9:15
    if ($strDate == false)																				return;

    if (isset($ar['records']) == false)																	return;
    foreach ($ar['records'] as $arPair)
    {
    	$strPair = $arPair['vrtEName'];
    	$strPrice = $arPair['price'];
    	DebugString($strPair.' '.$strPrice);
    	if ($strPair == 'USD/CNY')
    	{
    		DebugString('Insert USCNY');
			$nav_sql->InsertDaily($strUscnyId, $strDate, $strPrice);
		}
    	else if ($strPair == 'HKD/CNY')
    	{
    		DebugString('Insert HKCNY');
			$nav_sql->InsertDaily($strHkcnyId, $strDate, $strPrice);
		}
    }
}

?>
