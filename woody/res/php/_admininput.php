<?php
require_once('_stock.php');
require_once('_spdrnavxls.php');
require_once('/php/ui/editinputform.php');

function _getAdminInputArray()
{
	return array('admintest' => '超级功能测试',
				   'delstockgroup' => '删除股票分组',
				   'spdrnavxls' => '导入SPDR净值',
                 );
}

function _getAdminInputStr($strTitle)
{
    $ar = _getAdminInputArray();
	return $ar[$strTitle];
}

function _getAdminTestStr($strInput)
{
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
    	$sql->DeleteRecord($strWhere);
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
		$strInput = SqlCleanString($_POST[EDIT_INPUT_NAME]);
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
    	
  	case 'spdrnavxls':
    	$str = GetNavXlsStr($strInput);
    	break;
    }
    $str .= '<br /><br />'.GetCategoryLinks(_getAdminInputArray());
    EchoParagraph($str);
    $acct->EchoLinks();
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
  	$str = _getAdminInputTitle($strTitle, $acct->GetQuery()).'页面. ';
  	switch ($strTitle)
  	{
  	case 'admintest':
  		$str .= '用于测试代码的暂时放在_getAdminTestStr()函数中, 测试成熟后再分配具体长期使用的工具页面. 不成功的测试就可以直接放弃了.';
  		break;
  		
  	case 'delstockgroup':
  		$str .= '根据输入的stockgroup名字删除所有叫这个名字的股票分组, 以及所有相应的stockgroupitem等. 用在彻底删除一个页面后清理数据库.';
  		break;
  		
  	case 'spdrnavxls':
  		$str .= '根据输入的ETF名字导入SPDR官网上的.xls净值文件中的数据. https://us.spdrs.com/site-content/xls/XOP_HistoricalNav.xls';
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

	$acct = new StockAccount();
	$acct->AuthAdmin();
?>
