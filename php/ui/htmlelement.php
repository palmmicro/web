<?php

// ****************************** Pravite Functions *******************************************************

function _getHtmlElement($str)
{
    return "$str=\"$str\"";
}

// ****************************** Common Functions *******************************************************

function HtmlElementSelected()
{
    return _getHtmlElement('selected');
}

function HtmlElementDisabled()
{
    return _getHtmlElement('disabled');
}

function HtmlElementReadonly()
{
    $str = _getHtmlElement('readonly');
    $str .= ' style="background:#CCCCCC"';
    return $str;
}

function HtmlGetOption($ar, $strCompare = false)
{
    $str = '';
    foreach ($ar as $strKey => $strVal)
    {
    	$strSelected = ($strVal == $strCompare) ? ' '.HtmlElementSelected() : '';
       	$str .= "<OPTION value={$strKey}{$strSelected}>$strVal</OPTION>";
    }
    return $str;
}

function HtmlGetJsArray($ar)
{
	$str = '';
	foreach ($ar as $strId => $strVal)
	{
		$str .= $strId.':"'.$strVal.'", ';
	}
	return rtrim($str, ', ');
}

?>
