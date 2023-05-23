<?php

function ChinaMoneyGetUrl()
{
	return 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/data/fx/ccpr.json';
}

function _chinaMoneyNeedData($strDate)
{
	$nav_sql = GetNavHistorySql();
    if ($nav_sql->GetRecord(SqlGetStockId('USCNY'), $strDate))
    {
//    	DebugString('Database entry existed');
    	return false;
    }
    return $strDate;
}

function _chinaMoneyInsertData($strMoney, $strDate, $strPrice)
{
	DebugString('Insert '.$strMoney);
	$nav_sql = GetNavHistorySql();
	$nav_sql->InsertDaily(SqlGetStockId($strMoney), $strDate, $strPrice);
}

function GetChinaMoney($ref)
{
    if (_chinaMoneyNeedData($ref->GetDate()) == false)				return;
	if ($ref->GetHourMinute() < 915)									return;	// Data not updated until 9:15
    
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$strFileName = DebugGetChinaMoneyFile();
	if (StockNeedFile($strFileName) == false)						return; 	// updates on every minute
	
   	if ($str = url_get_contents(ChinaMoneyGetUrl()))
   	{
   		DebugString($strFileName.': Save new file');
   		file_put_contents($strFileName, $str);
   	}
   	else																return;	//	$str = file_get_contents($strFileName);
	
	$ar = json_decode($str, true);
    $arData = $ar['data'];
    $strDate = _chinaMoneyNeedData(substr($arData['lastDate'], 0, 10));		// 2018-04-12 9:15
    if ($strDate == false)											return;

    if (isset($ar['records']) == false)								return;
    foreach ($ar['records'] as $arPair)
    {
    	$strPair = $arPair['vrtEName'];
    	$strPrice = $arPair['price'];
    	DebugString($strPair.' '.$strPrice);
    	switch ($strPair)
    	{
    	case 'USD/CNY':
    		_chinaMoneyInsertData('USCNY', $strDate, $strPrice);
    		break;
    		
    	case 'EUR/CNY':
    		_chinaMoneyInsertData('EUCNY', $strDate, $strPrice);
    		break;
    		
    	case '100JPY/CNY':
    		_chinaMoneyInsertData('JPCNY', $strDate, $strPrice);
    		break;
    		
    	case 'HKD/CNY':
    		_chinaMoneyInsertData('HKCNY', $strDate, $strPrice);
    		break;
		}
    }
}

?>
