<?php
define('STOCK_PATH', '/woody/res/');
define('STOCK_PHP_PATH', '/woody/res/php/');

function GetNameTag($strName, $strDisplay)
{
	return '<a name="'.$strName.'">'.$strDisplay.'</a>';
}

function GetNameLink($strName, $strDisplay, $strLink = '')
{
	return '<a href="'.$strLink.'#'.$strName.'">'.$strDisplay.'</a>';
}

function GetOnClickLink($strPath, $strQuestion, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\" onclick=\"return confirm('$strQuestion')\">$strDisplay</a>";
    return $strLink;
}

function GetDeleteLink($strPath, $strCn, $strUs = '', $bChinese = true)
{
    if ($bChinese)
    {
        $strDisplay = '删除';
        $strQuestion = '确认删除'.$strCn;
    }
    else
    {
        $strDisplay = 'Delete';
        $strQuestion = 'Confirm delete '.$strUs;
    }
    return GetOnClickLink($strPath, $strQuestion.'?', $strDisplay);
}

function GetInternalLink($strPath, $strDisplay = false)
{
	if ($strDisplay == false)	$strDisplay = basename($strPath);
	
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\">$strDisplay</a>";
    return $strLink;
}

function GetExternalLink($strHttp, $strDisplay)
{
    $strLink = "<a href=\"$strHttp\" target=_blank>$strDisplay</a>";
    return $strLink;
}

function GetHttpLink($strHttp)
{
    return GetExternalLink($strHttp, $strHttp);
}

function GetFileLink($strPathName)
{
    return GetExternalLink(UrlGetServer().$strPathName, basename($strPathName));
}

function GetFileDebugLink($strPathName)
{
    $strLink = GetFileLink($strPathName);
    $strLastTime = DebugGetFileTimeDisplay($strPathName);
    $strDelete = GetOnClickLink('/php/_submitdelete.php?file='.$strPathName, '确认删除调试文件'.$strPathName.'?', $strLastTime);
    return "$strLink($strDelete)";
}

function GetPhpLink($strPathPage, $strQuery, $strDisplay, $strUs = false, $bChinese = true)
{
	if ($strUs && ($bChinese == false))
	{
		$strDisplay = $strUs;
	}
	
    $str = $strPathPage;
    $str .= UrlGetPhp($bChinese);
    if ($strQuery)
    {
        $str .= '?'.$strQuery;
    }
    return GetInternalLink($str, $strDisplay);
}

function CopyPhpLink($strQuery, $strCn, $strUs = false, $bChinese = true)
{
	return GetPhpLink(UrlGetUriPage(), $strQuery, $strCn, $strUs, $bChinese);
}

function GetSortString($strQuery)
{
    $ar = array('hshare' => STOCK_DISP_HSHARES,
                  'premium' => STOCK_DISP_PREMIUM,
                  'ratio' => STOCK_DISP_RATIO,
                 );
	return isset($ar[$strQuery]) ? '按'.$ar[$strQuery].'排序' : '';
}

function CopySortLink($strQuery = 'hshare')
{
    return CopyPhpLink(UrlAddQuery('sort='.$strQuery), GetSortString($strQuery));
}

function _getMenuLinkQuery($strId, $iStart, $iNum)
{
    $str = '';
    if ($strId)
    {
        $str = $strId.'&';
    }
    $str .= 'start='.strval($iStart).'&num='.strval($iNum);
    return $str;
}

function _getMenuDirLink($strDir, $strQueryId, $iStart, $iNum, $bChinese)
{
    $arDir = UrlGetMenuArray();
	$strQuery = _getMenuLinkQuery($strQueryId, $iStart, $iNum);
	return CopyPhpLink($strQuery, $arDir[$strDir], $strDir, $bChinese).' ';
}

function GetMenuLink($strQueryId, $iTotal, $iStart, $iNum, $bChinese = true)
{
    $str = ($bChinese ? '总数' : 'Total').': '.strval($iTotal);
    if ($iTotal <= 0 || ($iStart == 0 && $iNum == 0))		return $str;

    $iLast = $iStart + $iNum;
    if ($iLast > $iTotal)   $iLast = $iTotal;
    $str .= ' '.($bChinese ? '当前显示' : 'Current').': '.strval($iStart + 1).'-'.strval($iLast).' ';
    
    if ($iStart > 0)
    {   // Prev
        $iPrevStart = ($iStart > $iNum) ? ($iStart - $iNum) : 0;
        if ($iPrevStart != 0)	$str .= _getMenuDirLink(MENU_DIR_FIRST, $strQueryId, 0, $iNum, $bChinese);	// First
        $str .= _getMenuDirLink(MENU_DIR_PREV, $strQueryId, $iPrevStart, $iNum, $bChinese);
    }
    
    $iNextStart = $iStart + $iNum;
    if ($iNextStart < $iTotal)
    {   // Next
        $str .= _getMenuDirLink(MENU_DIR_NEXT, $strQueryId, $iNextStart, $iNum, $bChinese);
        if ($iNextStart + $iNum < $iTotal)		$str .= _getMenuDirLink(MENU_DIR_LAST, $strQueryId, $iTotal - $iNum, $iNum, $bChinese);		// Last
    }
    return $str;
}

function GetNewLink($strPathPage, $strNew, $bChinese = true)
{
    return GetPhpLink($strPathPage, 'new='.$strNew, '新建', 'New', $bChinese);
}

function GetEditLink($strPathPage, $strEdit, $bChinese = true)
{
    return GetPhpLink($strPathPage, 'edit='.$strEdit, '修改', 'Edit', $bChinese);
}

function GetPageLink($strPath, $strPage, $strQuery, $strDisplay, $bChinese = true)
{
    if ((UrlGetPage() == $strPage) && (UrlGetQueryString() == $strQuery))
    {
        return GetInfoFontElement($strDisplay);
    }
    return GetPhpLink($strPath.$strPage, $strQuery, $strDisplay, false, $bChinese);
}

function GetCategoryLinks($arCategory, $strPath = STOCK_PATH, $bChinese = true)
{
    $str = '';
    foreach ($arCategory as $strCategory => $strDisplay)
    {
    	$str .= GetPageLink($strPath, $strCategory, false, $strDisplay, $bChinese).' ';
    }
    return $str;
}

?>
