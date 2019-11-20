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

function FactorialFunction($iNum)
{
    // array_product 计算并返回数组的乘积
    // range 创建一个包含指定范围的元素的数组
    return array_product(range(1, $iNum));
}

define('SQRT2PI', 2.5066282746310005024157652848110452530069867406099);
function GammaFunction($data)
{
        if ($data == 0.0) {
            return 0;
        }
        else if ($data == intval($data))
        {
        	$iNum = intval($data) - 1;
        	return FactorialFunction($iNum);
        }

        static $p0 = 1.000000000190015;
        static $p = array(
            1 => 76.18009172947146,
            2 => -86.50532032941677,
            3 => 24.01409824083091,
            4 => -1.231739572450155,
            5 => 1.208650973866179e-3,
            6 => -5.395239384953e-6
        );

        $y = $x = $data;
        $tmp = $x + 5.5;
        $tmp -= ($x + 0.5) * log($tmp);

        $summer = $p0;
        for ($j=1; $j<=6; ++$j) {
            $summer += ($p[$j] / ++$y);
        }
        return exp(0 - $tmp + log(SQRT2PI * $summer / $x));
}

function GammaDensity($f, $fAlpha, $fBeta)
{
	$fVal = $f * $fBeta;
	return pow($fVal, $fAlpha - 1) * exp(0 - $fVal) / GammaFunction($fAlpha);
}

function GammaDistribution($f, $fAlpha, $fBeta)
{
//	$fGamma = GammaFunction($fAlpha);
//	DebugVal($fGamma, 'GammaDistribution');
//	return pow($f, $fAlpha - 1) * exp(0 - ($f / $fBeta)) / pow($fBeta, $fAlpha) / $fGamma;

	$a = $fAlpha;
	$x = $f * $fBeta;
	
        static $max = 32;
        $summer = 0;
        for ($n=0; $n<=$max; ++$n) {
            $divisor = $a;
            for ($i=1; $i<=$n; ++$i) {
                $divisor *= ($a + $i);
            }
            $summer += (pow($x, $n) / $divisor);
        }
//        return pow($x, $a) * exp(0-$x) * $summer / $fGamma;
	return GammaDensity($f, $fAlpha, $fBeta) * $summer * $x;
}

function ChiSquaredDistribution($f, $iNum)
{
	return 1.0 - GammaDistribution($f, $iNum / 2.0, 0.5);
}

function PearsonChiSquaredTest($arExpected, $arObserved)
{
	$iCount = count($arExpected);
	
	$fSum = 0.0;
	for ($i = 0; $i < $iCount; $i ++)
	{
		$fExpected = $arExpected[$i];
		if (empty($fExpected))	return false;
		
		$fSum += pow($arObserved[$i] - $fExpected, 2) / $fExpected;
	}
//	DebugVal($fSum, 'PearsonChiSquaredTest');

//	if ($iCount % 2)	
//	{
//		return	stats_cdf_chisquare($fSum, $iCount - 1, 1);
		return	ChiSquaredDistribution($fSum, $iCount - 1);
//	}
/*		
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
	
	if ($iCount > 10)		return false;
	$arProbability = $arDistribution[0];
	$arVal = $arDistribution[$iCount - 1];
	
	if ($fSum < $arVal[0])			return 1.0;
	else if ($fSum > $arVal[10])		return 0.0;

	for ($i = 0; $i < 10; $i ++)
	{
		if (($fSum >= $arVal[$i]) && ($fSum < $arVal[$i + 1]))
		{
			break;
		}
	}
	
	return $arProbability[$i] + ($arProbability[$i + 1] - $arProbability[$i]) * ($fSum - $arVal[$i]) / ($arVal[$i + 1] - $arVal[$i]);*/
}

?>
