<?php
require_once('/php/class/PHPExcel/IOFactory.php');

function _readXlsFile($bIshares, $strPathName, $nav_sql, $shares_sql, $strStockId)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
	try 
	{	// 读取excel文件
		$inputFileType = PHPExcel_IOFactory::identify($strPathName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($strPathName);
	} 
	catch(Exception $e) 
	{
		dieDebugString('Load excel file error: "'.pathinfo($strPathName, PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	
	if ($bIshares)
	{
		$iSheet = 1;
		$iNavIndex = 2;
		$iSharesIndex = 4;
	}
	else
	{
		$iSheet = 0;
		$iNavIndex = 1;
		$iSharesIndex = 2;
	}

	// 确定要读取的sheet，什么是sheet，看excel的右下角
	$sheet = $objPHPExcel->getSheet($iSheet);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();

	$oldest_ymd = new OldestYMD();
	$calibration_sql = new CalibrationSql();
	
	// 获取一行的数据
	$iCount = 0;
	$iSharesCount = 0;
	for ($row = 1; $row <= $highestRow; $row++)
	{
		// Read a row of data into an array
		$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, false);
		//这里得到的rowData都是一行的数据，得到数据后自行处理，我们这里只打出来看看效果
		$ar = $rowData[0];
		if ($iTick = strtotime($ar[0]))
		{
    		$ymd = new TickYMD($iTick);
    		$strDate = $ymd->GetYMD();
   			if ($oldest_ymd->IsInvalid($strDate) == false)
   			{
  				if ($nav_sql->WriteDaily($strStockId, $strDate, $ar[$iNavIndex]))
  				{
  					$iCount ++;
  					if ($calibration_sql->GetClose($strStockId, $strDate))
  					{
  						DebugString('Delete calibaration on '.$strDate);
  						$calibration_sql->DeleteByDate($strStockId, $strDate);
  					}
  				}
  				if ($shares_sql->WriteDaily($strStockId, $strDate, strval(floatval($ar[$iSharesIndex]) / 10000.0)))
  				{
  					$iSharesCount ++;
  				}
   			}
		}
	}
	return '更新'.strval($iCount).'条净值和'.strval($iSharesCount).'条流通股数';
}

function GetNavXlsStr($strSymbol)
{
   	if ($strUrl = GetEtfNavUrl($strSymbol))
	{
		$str = url_get_contents($strUrl);
		if ($str == false)	return '没读到数据';
		
//		$strFileName = basename($strUrl);
//		$strPathName = DebugGetPathName($strFileName);
		$strPathName = DebugGetPathName('NAV_'.$strSymbol.'.xls');
		file_put_contents($strPathName, $str);
		
		$strStockId = SqlGetStockId($strSymbol);
        $nav_sql = GetNavHistorySql();
        $shares_sql = new SharesHistorySql();
        $bIshares = (stripos($strUrl, 'ishares') !== false) ? true : false;
		return _readXlsFile($bIshares, $strPathName, $nav_sql, $shares_sql, $strStockId);
	}
	return $strSymbol.'不是SPDR或者ISHARES的ETF';
}

?>
