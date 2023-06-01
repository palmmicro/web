<?php
require_once('account.php');
require_once('sql/sqlstock.php');

function _deleteTableDataById($strTableName)
{
	if ($strId = UrlGetQueryValue($strTableName))
	{
		$sql = new TableSql($strTableName);
		return $sql->DeleteById($strId);
    }
    return false;
}

function SqlDeleteStockGroup($strGroupName)
{
	$group_sql = new StockGroupSql();
	$iCount = $group_sql->CountByString($strGroupName); 
	DebugVal($iCount, 'Total stock group named '.$strGroupName);
	if ($iCount > 0)	$group_sql->DeleteByString($strGroupName);
}

function SqlClearStockGroupItem()
{
	$item_sql = new StockGroupItemSql();
	DebugVal($item_sql->Count(), 'Total stock group items');
	
	$sql = GetStockSql();
	$group_sql = new StockGroupSql();
	$iCount = 0;
	$ar = array();
   	if ($result = $item_sql->GetAll())
   	{
   		while ($record = mysqli_fetch_assoc($result)) 
   		{
   			$strGroupId = $record['stockgroup_id'];
   			if ($group_sql->GetRecordById($strGroupId) == false)
   			{
   				$iCount ++;
   				$ar[] = $record['id'];
   				$strDebug = 'Missing group id: '.$strGroupId;
   				if ($strSymbol = $sql->GetStockSymbol($record['stock_id']))	$strDebug .= ' with '.$strSymbol.' '.$sql->GetStockName($strSymbol);
   				DebugString($strDebug);
    		}
    	}
   		mysqli_free_result($result);
    }
    
    if ($iCount > 0)
    {
    	DebugVal($iCount, 'Total error');
    	foreach ($ar as $strId)		$item_sql->DeleteById($strId);
    }
}

function SqlCleanStockTransaction()
{
	$trans_sql = new StockTransactionSql();
	DebugVal($trans_sql->CountData(), 'Total stock transactions');
	
	$item_sql = new StockGroupItemSql();
	$iCount = 0;
	$ar = array();
   	if ($result = $trans_sql->GetData())
   	{
   		while ($record = mysqli_fetch_assoc($result)) 
   		{
   			$strItemId = $record['groupitem_id'];
   			if ($item_sql->GetRecordById($strItemId) == false)
   			{
   				$iCount ++;
   				$ar[] = $record['id'];
   				DebugString('Missing stock group item id: '.$strItemId);
    		}
    	}
   		mysqli_free_result($result);
    }
    
    if ($iCount > 0)
    {
    	DebugVal($iCount, 'Total error');
    	foreach ($ar as $strId)		$trans_sql->DeleteById($strId);
    }
}

class _AdminDeleteAccount extends Account
{
	function DeleteVisitorByIp($strIp)
	{
   		$sql = $this->GetIpSql();
		if ($strId = GetIpId($strIp))
		{
			$visitor_sql = $this->GetVisitorSql();
			$iCount = $visitor_sql->CountBySrc($strId);
			$visitor_sql->DeleteBySrc($strId);        

			$sql->AddVisit($strIp, $iCount);
		}
		$sql->SetStatus($strIp, IP_STATUS_NORMAL);
	}

    public function AdminProcess()
    {
    	if ($strPathName = UrlGetQueryValue('file'))
    	{
    		unlinkEmptyFile($strPathName);
    		trigger_error('Deleted debug file: '.GetFileLink($strPathName)); 
    	}
    	else if ($strGroupName = UrlGetQueryValue('groupname'))
    	{
    		SqlDeleteStockGroup($strGroupName);
    		SqlClearStockGroupItem();	
    		SqlCleanStockTransaction();
    	}
    	else if ($strIp = UrlGetQueryValue('ip'))
    	{
    		$this->DeleteVisitorByIp($strIp);
    	}
    	else
    	{
			if (_deleteTableDataById('netvaluehistory'))		return;			
			if (_deleteTableDataById('fundest'))				return;			
		}
    }
}

   	$acct = new _AdminDeleteAccount();
	$acct->AdminRun();
?>
