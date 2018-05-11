<?php

function _SqlFetchIdArray($result)
{
    $arId = array();
    while ($record = mysql_fetch_assoc($result)) 
    {
        $arId[] = $record['id'];
    }
    @mysql_free_result($result);
    return $arId;
}

function _SqlBuildWhere($strKey, $strVal)
{
    if ($strVal)  
    {
        return "$strKey = '$strVal'";
    }
    return false;
}

function _SqlBuildWhere_member($strMemberId)
{
	return _SqlBuildWhere('member_id', $strMemberId);
}

function _SqlBuildWhere_stock($strStockId)
{
	return _SqlBuildWhere('stock_id', $strStockId);
}

function _SqlBuildWhere_id($strId)
{
	return _SqlBuildWhere('id', $strId);
}

function _SqlBuildWhereOrArray($strKey, $arVal)
{
    $strOr = ' OR ';
    $str = '';
    foreach ($arVal as $strVal)
    {
        if ($strWhere = _SqlBuildWhere($strKey, $strVal))
        {
            $str .= $strWhere.$strOr; 
        }
    }
    
    if ($str != '')
    {
        $str = rtrim($str, $strOr); 
        return $str; 
    }
    return false;
}

function _SqlBuildWhereAndArray($arVal)
{
    $strAnd = ' AND ';
    $str = '';
    foreach ($arVal as $strKey => $strVal)
    {
        if ($strWhere = _SqlBuildWhere($strKey, $strVal))
        {
            $str .= $strWhere.$strAnd; 
        }
    }
    
    if ($str != '')
    {
        $str = rtrim($str, $strAnd); 
        return $str; 
    }
    return false;
}

function _SqlBuildWhere_stock_member($strStockId, $strMemberId)
{
	return _SqlBuildWhereAndArray(array('stock_id' => $strStockId, 'member_id' => $strMemberId));
}

function _SqlBuildWhere_date_stock($strDate, $strStockId)
{
	return _SqlBuildWhereAndArray(array('date' => $strDate, 'stock_id' => $strStockId));
}

function _SqlBuildLimit($iStart, $iNum)
{
	if ($iStart == 0)
	{
	    if ($iNum != 0)
	    {
	        return strval($iNum);
	    }
	}
	else
	{
        return strval($iStart).' , '.strval($iNum);
	}
    return false;    
}

function _SqlOrderByDateTime()
{
    return '`date` DESC, `time` DESC';
}

function _SqlOrderByDate()
{
    return '`date` DESC';
}

?>
