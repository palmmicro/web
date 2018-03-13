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

function _SqlBuildWhereArray($arVal, $strOr)
{
    $str = '';
    foreach ($arVal as $strVal => $strKey)
    {
        if ($strWhere = _SqlBuildWhere($strKey, $strVal))
        {
            $str .= $strWhere.$strOr; 
        }
    }
    
    if ($str != '')
    {
        $str = rtrim($str, $strOr); 
//        DebugString($str);
        return $str; 
    }
    return false;
}

function _SqlBuildWhereOrArray($strKey, $arVal)
{
	$ar = array();
	foreach ($arVal as $strVal)
	{
		$ar[$strVal] = $strKey;
	}
	return _SqlBuildWhereArray($ar, ' OR ');
}

function _SqlBuildWhereAndArray($arVal)
{
	return _SqlBuildWhereArray($arVal, ' AND ');
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

?>
