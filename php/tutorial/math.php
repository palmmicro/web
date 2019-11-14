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
    	
   	if (empty($fSxx) || empty($fSyy))	return array(0.0, 0.0, 0.0);
   	
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

function PearsonChiSquaredTest($arExpected, $arObserved)
{
	$arDistribution = array(array(0.95, 0.90, 0.80, 0.70, 0.50, 0.30, 0.20, 0.10, 0.05, 0.01, 0.001),
								array(0.004, 0.02, 0.06, 0.15, 0.46, 	1.07, 1.64, 2.71, 3.84, 6.64, 10.83),
								array(0.10, 0.21, 	0.45, 0.71, 1.39, 2.41, 3.22, 	4.60, 5.99, 9.21, 13.82),
								array(0.35, 0.58, 	1.01, 1.42, 2.37, 3.66, 4.64, 	6.25, 7.82, 11.34, 16.27),
								array(0.71, 1.06, 	1.65, 2.20, 3.36, 4.88, 5.99, 	7.78, 9.49, 13.28, 18.47),
								array(1.14, 1.61, 	2.34, 3.00, 4.35, 6.06, 7.29, 	9.24, 11.07, 15.09, 20.52),
								array(1.63, 2.20, 	3.07, 3.83, 5.35, 7.23, 8.56, 	10.64, 12.59, 16.81, 22.46),
								array(2.17, 2.83, 	3.82, 4.67, 6.35, 8.38, 9.80, 	12.02, 14.07, 18.48, 24.32),
								array(2.73, 3.49, 	4.59, 5.53, 7.34, 9.52, 11.03, 13.36, 15.51, 20.09, 26.12),
								array(3.32, 4.17, 	5.38, 6.39, 8.34, 10.66, 12.24, 14.68, 16.92, 21.67, 	27.88),
								array(3.94, 4.86, 	6.18, 7.27, 9.34, 11.78, 13.44, 15.99, 18.31, 23.21, 	29.59)
								);
	
	$iCount = count($arExpected);
	$arProbability = $arDistribution[0];
	$arVal = $arDistribution[$iCount - 1];
	
	$fSum = 0.0;
	for ($i = 0; $i < $iCount; $i ++)
	{                                     
		$fSum += pow($arObserved[$i] - $arExpected[$i], 2) / $arExpected[$i];
	}
	
	if ($fSum < $arVal[0])			return 1.0;
	else if ($fSum > $arVal[10])		return 0.0;

	for ($i = 0; $i < 10; $i ++)
	{
		if (($fSum >= $arVal[$i]) && ($fSum < $arVal[$i + 1]))
		{
			break;
		}
	}
	
	return $arProbability[$i] + ($arProbability[$i + 1] - $arProbability[$i]) * ($fSum - $arVal[$i]) / ($arVal[$i + 1] - $arVal[$i]);
}

?>
