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
    return '[\S\s]*';
}

function RegExpDigit()
{
    return '[\d]*';
}

function RegExpNumber()
{
    return '[\d.-]*';
}

function RegExpParenthesis($strLeft, $strMid, $strRight) 
{
    return $strLeft.'('.$strMid.')'.$strRight;
}

?>
