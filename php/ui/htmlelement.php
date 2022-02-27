<?php

function GetDoubleQuotes($str)
{
	return '"'.$str.'"';
}

function GetImgElement($strPathName, $strText)
{
	return '<img src='.$strPathName.' alt='.GetDoubleQuotes($strText).' />';
}

function GetBreakElement()
{
	return '<br />';
}

function GetHtmlElement($strContent, $strTag = 'p', $arAttribute = false)
{
	$strStart = $strTag;
	if ($arAttribute)
	{
		foreach ($arAttribute as $strAttribute => $strValue)	$strStart .= ' '.$strAttribute.'='.$strValue;
	}
	return "<$strStart>$strContent</$strTag>";
}

function GetLinkElement($strContent, $strPathName, $arExtraAttribute = false)
{
	$ar = array('href' => GetDoubleQuotes($strPathName));
	if ($arExtraAttribute)	$ar = array_merge($ar, $arExtraAttribute); 
	return GetHtmlElement($strContent, 'a', $ar);
}

function GetBoldElement($strContent)
{
	return GetHtmlElement($strContent, 'b');
}

function GetFontElement($strContent, $strColor = 'red', $strStyle = false)
{
	$ar = array('color' => $strColor);
	if ($strStyle)	$ar['style'] = GetDoubleQuotes($strStyle);
	return GetHtmlElement($strContent, 'font', $ar);
}

function GetQuoteElement($strContent, $strStyle = false)
{
	return GetFontElement($strContent, 'gray', $strStyle);
}

function GetInfoElement($strContent)
{
	return GetFontElement($strContent, 'blue');
}

function GetRemarkElement($strContent)
{
	return GetFontElement($strContent, 'green');
}

function GetListElement($arContent, $bOrder = true)
{
	$str = '';
	foreach ($arContent as $strContent)	$str .= GetHtmlElement($strContent, 'li');
	return GetHtmlElement($str, ($bOrder ? 'ol' : 'ul'));
}

function _setHtmlElement($str)
{
    return "$str=\"$str\"";
}

function HtmlElementSelected()
{
    return _setHtmlElement('selected');
}

function HtmlElementDisabled()
{
    return _setHtmlElement('disabled');
}

function HtmlElementReadonly()
{
    $str = _setHtmlElement('readonly');
    $str .= ' style="background:#CCCCCC"';
    return $str;
}

function HtmlGetOption($ar, $strCompare = false)
{
    $str = '';
    foreach ($ar as $strKey => $strVal)
    {
    	$strSelected = ($strVal == $strCompare) ? ' '.HtmlElementSelected() : '';
//       	$str .= "<OPTION value={$strKey}{$strSelected}>$strVal</OPTION>";
		$str .= GetHtmlElement($strVal, 'OPTION', array('value' => $strKey.$strSelected));
    }
    return $str;
}

function HtmlGetJsArray($ar)
{
	$str = '';
	foreach ($ar as $strId => $strVal)		$str .= $strId.':"'.$strVal.'", ';
	return rtrim($str, ', ');
}

?>
