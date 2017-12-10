<?php

// ****************************** Pravite Functions *******************************************************

function _getHtmlElement($str)
{
    return "$str=\"$str\"";
}

// ****************************** Common Functions *******************************************************

function HtmlElementDisabled()
{
    return _getHtmlElement('disabled');
}

function HtmlElementReadonly()
{
    return _getHtmlElement('readonly');
}

?>
