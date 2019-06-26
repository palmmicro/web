<?php
require_once('_stock.php');
require_once('/php/ui/editinputform.php');
require_once('/php/class/PHPExcel/IOFactory.php');

function _getAdminInputArray()
{
	return array('admintest' => '超级功能测试',
				   'delstockgroup' => '删除股票分组',
                 );
}

function _getAdminInputStr($strTitle)
{
    $ar = _getAdminInputArray();
	return $ar[$strTitle];
}

function _readXlsFile($strPathName)
{
	date_default_timezone_set(DEBUG_TIME_ZONE);
	// 读取excel文件
	try 
	{
		$inputFileType = PHPExcel_IOFactory::identify($strPathName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($strPathName);
	} 
	catch(Exception $e) 
	{
		die('加载文件发生错误: "'.pathinfo($strPathName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	// 确定要读取的sheet，什么是sheet，看excel的右下角，真的不懂去百度吧
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	DebugString($highestRow);
	$highestColumn = $sheet->getHighestColumn();
	DebugString($highestColumn);

	// 获取一行的数据
	for ($row = 1; $row <= $highestRow; $row++)
	{
		// Read a row of data into an array
		$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, false);
		//这里得到的rowData都是一行的数据，得到数据后自行处理，我们这里只打出来看看效果
//		DebugArray($rowData[0]);
//		var_dump($rowData);
		$ar = $rowData[0];
		if ($iTick = strtotime($ar[0]))
		{
//			DebugString($ar[0].' '.$ar[1]);
		}
	}
}

// https://us.spdrs.com/site-content/xls/XOP_HistoricalNav.xls
function _getAdminTestStr($strInput)
{
	if ($strInput == 'XLE' || $strInput == 'XOP')
	{
		$strFileName = $strInput.'_HistoricalNav.xls';
		$strUrl = 'https://us.spdrs.com/site-content/xls/'.$strFileName;
		$str = url_get_contents($strUrl);
//		DebugString($str);
		$strPathName = DebugGetPathName($strFileName);
		file_put_contents($strPathName, $str);
		_readXlsFile($strPathName);
	}
	return $strInput;
}

function _getDelStockGroupStr($strGroupName)
{
	if (strlen($strGroupName) == 0)		return '请输入要删除的股票分组名称';

	$sql = new StockGroupSql();
    $strWhere = _SqlBuildWhere('groupname', $strGroupName);
    $iCount = $sql->CountData($strWhere);
    $str = 'GroupName: '.$strGroupName.' total '.strval($iCount);
    if ($iCount > 0)
    {
    	if ($result = $sql->GetData($strWhere))
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			SqlDeleteStockGroupItemByGroupId($record['id']);
    		}
    		@mysql_free_result($result);
    	}
    	$sql->DeleteData($strWhere);
    }

	return $str;
}

function EchoAll()
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
	
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strInput = UrlCleanString($_POST[EDIT_INPUT_NAME]);
	}
	else if ($strInput = $acct->GetQuery())	{}
    else
    {
    	switch ($strTitle)
    	{
    	case 'admintest':
    		$strInput = strval(time());
    		break;
    		
    	default:
    		$strInput = '';
    		break;
    	}
    }
    
    EchoEditInputForm(_getAdminInputStr($strTitle), $strInput);
    switch ($strTitle)
    {
    case 'admintest':
    	$str = _getAdminTestStr($strInput);
    	break;
    		
    case 'delstockgroup':
    	$str = _getDelStockGroupStr($strInput);
    	break;
    }
    $str .= '<br /><br />'.GetCategoryLinks(_getAdminInputArray());
    EchoParagraph($str);
}

function _getAdminInputTitle($strTitle, $strQuery)
{
	$str = $strQuery ? $strQuery.' ' : '';
	$str .= _getAdminInputStr($strTitle);
	return $str;
}

function EchoMetaDescription()
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
  	$str = _getAdminInputTitle($strTitle, $acct->GetQuery());
  	switch ($strTitle)
  	{
  	case 'admintest':
  		$str .= '页面. 用于测试代码的暂时放在_getAdminTestStr()函数中, 测试成熟后再分配具体长期使用的工具页面. 不成功的测试就可以直接放弃了.';
  		break;
  		
  	case 'delstockgroup':
  		$str .= '页面. 根据输入的stockgroup名字删除所有叫这个名字的股票分组, 以及所有相应的stockgroupitem等. 用在彻底删除一个页面后清理数据库.';
  		break;
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
  	$str = _getAdminInputTitle($strTitle, $acct->GetQuery());
  	echo $str;
}

	$acct = new TitleAcctStart();
	if ($acct->IsAdmin() == false)
	{
        AcctSwitchToLogin();
	}

?>
