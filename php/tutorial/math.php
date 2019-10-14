<?php

function SquareSum($arF)
{
  	$f = 0.0;
   	foreach ($arF as $fVal)
   	{
   		$f += pow($fVal, 2);
   	}
   	return $f;
}
    
function LinearRegression($arX, $arY)
{
   	$iCount = count($arX);
   	$fMeanX = array_sum($arX) / $iCount;
   	$fMeanY = array_sum($arY) / $iCount;
    	
   	$fSxx = SquareSum($arX) - $iCount * pow($fMeanX, 2);
   	$fSyy = SquareSum($arY) - $iCount * pow($fMeanY, 2);
    	
   	$fSxy = 0.0;
   	foreach ($arX as $strKey => $fX)
   	{
   		$fSxy += $fX * $arY[$strKey];
   	}
   	$fSxy -= $iCount * $fMeanX * $fMeanY;
    	
   	$fB = $fSxy / $fSxx;
   	$fA = $fMeanY - $fB * $fMeanX;
    $fR = $fSxy / sqrt($fSxx) / sqrt($fSyy);
	return array($fA, $fB, $fR);
}

function CramersRule($fA1, $fB1, $fC1, $fA2, $fB2, $fC2)
{
	$f = $fA1 * $fB2 - $fB1 * $fA2;
	if (empty($f))
	{
		return false;
	}
	
	$fX = ($fC1 * $fB2 - $fB1 * $fC2) / $f;
	$fY = ($fA1 * $fC2 - $fC1 * $fA2) / $f;
	return array($fX, $fY);
}

?>
