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

function _formatPairStr($strSymbol, $fVal, $fPos)
{
	return $strSymbol.'净值: '.strval_round($fVal, 4).' 仓位: '.strval($fPos);
}

function _formatPairSharesStr($strSymbol, $fShares)
{
	return $strSymbol.'对应股数: '.strval_round($fShares, 0);
}

function _formatPairRemainStr($strSymbol, $fShares)
{
	return $strSymbol.'剩余股数: '.strval_round($fShares, 0);
}

function _getAdminTestStr($strInput)
{
	$strSrc = 'SZ162719';
	$strDst = 'SZ162411';
	$strEstInput = '105';
	
	StockPrefetchData($strSrc, $strDst);
    $src_ref = new QdiiReference($strSrc);
    $dst_ref = new QdiiReference($strDst);
    
    if (($strSrcVal = $src_ref->GetOfficialNetValue()) && ($strDstVal = $dst_ref->GetOfficialNetValue()))
    {
    	$fSrcVal = floatval($strSrcVal);
    	$fDstVal = floatval($strDstVal);
    	
    	$fSrcPos = $src_ref->GetFundPosition();
    	$fDstPos = $dst_ref->GetFundPosition();
    	
    	$str = _formatPairStr($strSrc, $fSrcVal, $fSrcPos);
    	$str .= '<br />'._formatPairStr($strDst, $fDstVal, $fDstPos);
    	
    	$fSrc = $fSrcVal * $fSrcPos;
    	$fInput = $fSrc * floatval($strInput);
    	$fOutput = $fInput / $fDstVal / $fDstPos;
    	$str .= '<br />'._formatPairSharesStr($strDst, $fOutput);
    	
    	$est_ref = $dst_ref->GetEstRef();
    	$strEst = $est_ref->GetSymbol();
       	$sql = new NetValueSql($est_ref->GetStockId());
       	$uscny_sql = new UscnyHistorySql();
       	
    	$strDate = $dst_ref->GetOfficialDate();
    	$strEstVal = $sql->GetClose($strDate);
    	$strCny = $uscny_sql->GetClose($strDate);
    	
    	$fEst = floatval($strEstVal) * floatval($strCny);
    	$str .= '<br /><br />'.$strDate.' '.$strEstVal.' '.$strCny.' '.strval_round($fEst / $fSrc);
    	$fEstOutput = ($fEst == 0.0) ? 0.0 : $fInput / $fEst;
    	$str .= '<br />'._formatPairSharesStr($strEst, $fEstOutput);
    	
    	$fEstRemain = floatval($strEstInput) - $fEstOutput;
    	$str .= '<br /><br />'._formatPairRemainStr($strEst, $fEstRemain);
    	
    	$fDstRemain = $fEstRemain * 1400;
    	$str .= '<br />'._formatPairRemainStr($strDst, $fDstRemain);
    	
    	return $str;
    }
	
    return '未知错误';
//	return $strInput;
}

function _getDelStockGroupStr($sql, $strGroupName)
{
	if (strlen($strGroupName) == 0)		return '请输入要删除的股票分组名称';

//	$sql = new StockGroupSql();
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
    	$str = _getDelStockGroupStr($acct->GetGroupSql(), $strInput);
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
