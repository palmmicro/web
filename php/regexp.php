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
    return '[\d,.-KMBT]*';
}

function RegExpDate()
{
    return '\d{4}-\d{2}-\d{2}';
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
    	DebugVal($iCount, $strSrc);
    	DebugPrint($arMatch);
    }
    return $iCount;
}

function PregMatchSquareBracket($strPrefix, $str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis($strPrefix.'\[', '[^\]]*', '\]');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    if (preg_match($strPattern, $str, $arMatch) == 1)
    {
    	return $arMatch[1];
    }
    return false;
}

?>
