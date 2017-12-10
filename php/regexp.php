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

function RegExpParenthesis($strLeft, $strMid, $strRight) 
{
    return $strLeft.'('.$strMid.')'.$strRight;
}

?>
