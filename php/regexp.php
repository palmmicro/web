<?php

function RegExpBoundary() 
{
//    return '/';
    return '#';
}

function RegExpSpace() 
{
    return '\s*';
}

function RegExpNoneSpace()
{
    return '\S*';
}

function RegExpAll()
{
    return '[\S\s]*?';
}

function RegExpDigit()
{
    return '[\d]*';
}

function RegExpNumber()
{
    return '[\d.-]*';
}

function RegExpFmtNumber()
{
    return '[\d,.-]*';
}

function RegExpParenthesis($strLeft, $strMid, $strRight) 
{
    return $strLeft.'('.$strMid.')'.$strRight;
}

function RegExpSkip($strPattern) 
{
    return '(?:'.$strPattern.')?';
}

function RegExpStockSymbol($strSymbol)
{
	$sym = new StockSymbol($strSymbol);
	if ($sym->IsIndex())
	{
		return '\\'.$strSymbol;
	}
	return $strSymbol;
}

function RegExpDebug($arMatch, $strSrc, $iMin)
{
	$iCount = count($arMatch);
    if ($iCount > $iMin)
    {
    	DebugString($strSrc.' '.strval($iCount).':');
    	foreach ($arMatch as $ar)
    	{
    		foreach ($ar as $str)	DebugString($str);
    	}
    }
    return $iCount;
}


?>
