<?php
require_once('debug.php');
require_once('sqlquery.php');

// ****************************** Sql database maintenance functions *******************************************************

function DeleteStockGroupByName($strGroupName)
{
    $strGroupTable = 'stockgroup';
    $strGroupWhere = _SqlBuildWhere('groupname', $strGroupName);
    DebugString($strGroupWhere);
    $iGroupCount = SqlCountTableData($strGroupTable, $strGroupWhere);
    DebugVal($iGroupCount);
    if (($result = SqlGetTableData($strGroupTable, $strGroupWhere, false, false)) == false)   return;
    
    $strItemWhere = _SqlBuildWhereOrArray('group_id', _SqlFetchIdArray($result));
    $strItemTable = 'stockgroupitem';
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
    if ($result = SqlGetTableData('blog', false, false, false)) 
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
        SqlDeleteTableDataById('blog', $str);
    }
}

?>
