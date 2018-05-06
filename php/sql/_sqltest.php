<?php

// ****************************** Sql database maintenance functions *******************************************************

function DeleteStockGroupByName($strGroupName)
{
    $strGroupTable = TABLE_STOCK_GROUP;
    $strGroupWhere = _SqlBuildWhere('groupname', $strGroupName);
    DebugString($strGroupWhere);
    $iGroupCount = SqlCountTableData($strGroupTable, $strGroupWhere);
    DebugVal($iGroupCount);
    if (($result = SqlGetTableData($strGroupTable, $strGroupWhere, false, false)) == false)   return;
    
    $strItemWhere = _SqlBuildWhereOrArray('group_id', _SqlFetchIdArray($result));
    $strItemTable = TABLE_STOCK_GROUP_ITEM;
    $iItemCount = SqlCountTableData($strItemTable, $strItemWhere);
    DebugVal($iItemCount);
    if (($result = SqlGetTableData($strItemTable, $strItemWhere, false, false)) == false)   return;

    $strTransactionWhere = _SqlBuildWhereOrArray('groupitem_id', _SqlFetchIdArray($result));
    $strTransactionTable = 'stocktransaction';
    $iTransactionCount = SqlCountTableData($strTransactionTable, $strTransactionWhere);
    DebugVal($iTransactionCount);
/*    
    if ($iTransactionCount > 0)    SqlDeleteTableData($strTransactionTable, $strTransactionWhere, false);
    if ($iItemCount > 0)    SqlDeleteTableData($strItemTable, $strItemWhere, false);
    if ($iGroupCount > 0)    SqlDeleteTableData($strGroupTable, $strGroupWhere, false);
*/    
}

function ValidateTableIpField($strTableName)
{
    $ar = array();
    if ($result = SqlGetTableData($strTableName, false, false, false)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (!filter_valid_ip($record['ip']))
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }
    
    $iCount = count($ar);
    DebugString($strTableName.': invalid ip number: '.strval($iCount)); 
    if ($iCount > 0)
    {
        foreach ($ar as $strId)
        {
            SqlDeleteTableDataById($strTableName, $strId);
        }
    }
}

function CorrectBlogTable()
{
    $ar = array();
    if ($result = SqlGetTableData(TABLE_BLOG, false, false, false)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (substr($record['uri'], 0, 2) == '//')
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }
    DebugVal(count($ar));
    
    foreach ($ar as $str)
    {
        SqlDeleteTableDataById(TABLE_BLOG, $str);
    }
}

/*
function SqlInsertFuture()
{
    SqlInsertStock('hf_CL', 'NYMEX Oil Future', 'NYMEX原油期货');
    SqlInsertStock('hf_GC', 'COMEX Gold Future', 'COMEX黄金期货');
    SqlInsertStock('hf_NG', 'NYMEX Gas Future', 'NYMEX天然气期货');
    SqlInsertStock('hf_OIL', 'Brent Oil Future', '布伦特原油期货');
    SqlInsertStock('hf_SI', 'COMEX Silver Future', 'COMEX白银期货');
}

function SqlInsertUSCNY()
{
    SqlInsertStock('USCNY', 'USD/CNY Reference Rate', '美元人民币中间价');
}

function SqlInsertHKCNY()
{
    SqlInsertStock('HKCNY', 'HKD/CNY Reference Rate', '港币人民币中间价');
}
*/

?>
