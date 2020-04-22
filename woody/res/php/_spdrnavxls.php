<?php
require_once('/php/class/PHPExcel/IOFactory.php');

function _readXlsFile($strPathName, $sql, $shares_sql)
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

	// 确定要读取的sheet，什么是sheet，看excel的右下角
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();

	$oldest_ymd = new OldestYMD();
	
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
  				if ($sql->Write($strDate, $ar[1]))
  				{
  					$iCount ++;
  				}
  				if ($shares_sql->Write($strDate, strval(floatval($ar[2]) / 10000.0)))
  				{
  					$iSharesCount ++;
  				}
   			}
		}
	}
	return '更新'.strval($iCount).'条净值和'.strval($iSharesCount).'条流通股数';
}

function GetSpdrNavXlsStr($strSymbol)
{
   	if ($strUrl = GetSpdrNavUrl($strSymbol))
	{
		$str = url_get_contents($strUrl);
		if ($str == false)	return '没读到数据';
		
		$strFileName = basename($strUrl);
		$strPathName = DebugGetPathName($strFileName);
		file_put_contents($strPathName, $str);
		
		$strStockId = SqlGetStockId($strSymbol);
        $sql = new NetValueHistorySql($strStockId);
        $shares_sql = new EtfSharesHistorySql($strStockId);
		return _readXlsFile($strPathName, $sql, $shares_sql);
	}
	return $strSymbol.'不是SPDR的ETF';
}

?>
