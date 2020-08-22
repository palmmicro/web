<?php

function _SqlBuildWhere($strKey, $strVal)
{
    return ($strVal === false) ? false : "$strKey = '$strVal'";
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
/*
function _SqlBuildWhereAnd()
{
    return _SqlBuildWhereAndArray(func_get_args());
}
*/
function _SqlBuildWhere_stock_member($strStockId, $strMemberId)
{
	return _SqlBuildWhereAndArray(array('stock_id' => $strStockId, 'member_id' => $strMemberId));
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

function _SqlComposeDateTimeIndex()
{
	return ' INDEX ( `date`, `time` )';
}

function _SqlOrderByDateTime()
{
    return '`date` DESC, `time` DESC';
}

function _SqlOrderByDate()
{
    return '`date` DESC';
}

function _sqlAddClause($strClause, $strParameter)
{
	if ($strParameter)
	{
		return " $strClause $strParameter";
	}
	return '';
}

function _SqlAddWhere($strWhere)
{
	return _sqlAddClause('WHERE', $strWhere);
}

function _SqlAddOrder($strOrder)
{
	return _sqlAddClause('ORDER BY', $strOrder);
}

function _SqlAddLimit($strLimit)
{
	return _sqlAddClause('LIMIT', $strLimit);
}

?>
