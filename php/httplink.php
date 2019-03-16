<?php
//require_once('url.php');
require_once('debug.php');

define('STOCK_PATH', '/woody/res/');
define('STOCK_PHP_PATH', '/woody/res/php/');

define('DEFAULT_NAV_DISPLAY', 100);

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

function GetInternalLink($strPath, $strDisplay)
{
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

function GetCurLink()
{
    $strHttp = UrlGetCur();
    return GetHttpLink($strHttp);
}

function GetFileLink($strPathName)
{
	$strFileName = UrlGetFileName($strPathName);
/*	if (strlen($strFileName) > 10)
	{
		$strFileName = substr($strFileName, -10, 10);
	}*/
    return GetExternalLink(UrlGetServer().$strPathName, $strFileName);
}

function GetFileDebugLink($strPathName)
{
    $strLink = GetFileLink($strPathName);
    $strLastTime = DebugGetFileTimeDisplay($strPathName);
    $strDelete = GetOnClickLink('/php/_submitdelete.php?file='.$strPathName, '确认删除调试文件'.$strPathName.'?', $strLastTime);
    return "$strLink($strDelete)";
}

function GetPhpLink($strPathTitle, $bChinese, $strDisplay, $strUs = false, $strQuery = false)
{
	if ($strUs && ($bChinese == false))
	{
		$strDisplay = $strUs;
	}
	
    $str = $strPathTitle;
    $str .= UrlGetPhp($bChinese);
    if ($strQuery)
    {
        $str .= '?'.$strQuery;
    }
    return GetInternalLink($str, $strDisplay);
}

function CopyPhpLink($strQuery, $bChinese, $strCn, $strUs = false)
{
	return GetPhpLink(UrlGetUriTitle(), $bChinese, $strCn, $strUs, $strQuery);
}

function _getNavLinkQuery($strId, $iStart, $iNum)
{
    $str = '';
    if ($strId)
    {
        $str = $strId.'&';
    }
    $str .= 'start='.strval($iStart).'&num='.strval($iNum);
    return $str;
}

function GetNavLink($strQueryId, $iTotal, $iStart, $iNum, $bChinese = true)
{
	$strTotal = strval($iTotal);
    $str = ($bChinese ? '总数' : 'Total').': ';	//.strval($iTotal).' ';
    if ($iTotal <= 0)		return $str.$strTotal;

    if ($iTotal > $iNum && $iTotal < 2000)
    {
    	$strQuery = _getNavLinkQuery($strQueryId, 0, $iTotal);
    	$str .= CopyPhpLink($strQuery, $bChinese, $strTotal).' ';
    }
    else
    {
    	$str .= $strTotal.' ';
    }
    
    $iLast = $iStart + $iNum;
    if ($iLast > $iTotal)   $iLast = $iTotal;
    $str .= ($bChinese ? '当前显示' : 'Current').': '.strval($iStart + 1).'-'.strval($iLast).' ';
    
    $arDir = UrlGetNavDisplayArray();
    if ($iStart > 0)
    {   // Prev
        if ($iStart > $iNum)
        {
            $iPrevStart = $iStart - $iNum;
        }
        else
        {
            $iPrevStart = 0;
        }
        
        if ($iPrevStart != 0)
        {   // First
            $strQuery = _getNavLinkQuery($strQueryId, 0, $iNum);
            $str .= CopyPhpLink($strQuery, $bChinese, $arDir[NAV_DIR_FIRST], NAV_DIR_FIRST).' ';
        }
        $strQuery = _getNavLinkQuery($strQueryId, $iPrevStart, $iNum);
        $str .= CopyPhpLink($strQuery, $bChinese, $arDir[NAV_DIR_PREV], NAV_DIR_PREV).' ';
    }
    
    $iNextStart = $iStart + $iNum;
    if ($iNextStart < $iTotal)
    {   // Next
        $strQuery = _getNavLinkQuery($strQueryId, $iNextStart, $iNum);
        $str .= CopyPhpLink($strQuery, $bChinese, $arDir[NAV_DIR_NEXT], NAV_DIR_NEXT).' ';
        if ($iNextStart + $iNum < $iTotal)
        {   // Last
            $strQuery = _getNavLinkQuery($strQueryId, $iTotal - $iNum, $iNum);
            $str .= CopyPhpLink($strQuery, $bChinese, $arDir[NAV_DIR_LAST], NAV_DIR_LAST);
        }
    }
    return $str;
}

function GetNewLink($strPathTitle, $strNew, $bChinese)
{
    return GetPhpLink($strPathTitle, $bChinese, '新建', 'New', 'new='.$strNew);
}

function GetEditLink($strPathTitle, $strEdit, $bChinese = true)
{
    return GetPhpLink($strPathTitle, $bChinese, '修改', 'Edit', 'edit='.$strEdit);
}

function GetTitleLink($strPath, $strTitle, $bChinese, $strDisplay, $strUs = false, $strQuery = false)
{
	if ($strUs && ($bChinese == false))
	{
		$strDisplay = $strUs;
	}
	
    if ((UrlGetTitle() == $strTitle) && (UrlGetQueryString() == $strQuery))
    {
        return "<font color=blue>$strDisplay</font>";
    }
    return GetPhpLink($strPath.$strTitle, $bChinese, $strDisplay, false, $strQuery);
}

function GetCategoryLinks($callback, $bChinese, $strPath = STOCK_PATH)
{
	$arCategory = call_user_func($callback, $bChinese);
    $str = '';
    foreach ($arCategory as $strCategory => $strDisplay)
    {
    	$str .= GetTitleLink($strPath, $strCategory, $bChinese, $strDisplay).' ';
    }
    return $str;
}

?>
