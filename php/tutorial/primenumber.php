<?php
require_once('/php/debug.php');

function _lookUpPrimeNumber($iNum)
{
	$aiPrime = array(2);
	for ($i = 3; ($i * $i) <= $iNum; $i += 2)
	{
		$bPrime = true;
		foreach ($aiPrime as $iPrime)
		{
			if ($iPrime * $iPrime > $i)		break;
			else if (($i % $iPrime) == 0)
			{
				$bPrime = false;
				break;
			}
		}
		if ($bPrime)	$aiPrime[] = $i;
	}

	$aiNum = array();
	foreach ($aiPrime as $iPrime)
	{
		if ($iPrime * $iPrime > $iNum)	break;
		while (($iNum % $iPrime) == 0)
		{
			$iNum /= $iPrime;
			$aiNum[] = $iPrime;
		}
	}
	if ($iNum > 1) 		$aiNum[] = $iNum;
	return $aiNum;
}

function _onePassPrimeNumber($iNum)
{
	$aiNum = array();
	for ($i = 2; ($i * $i) <= $iNum; $i ++)
	{
		while (($iNum % $i) == 0)
		{
			$iNum /= $i;
			$aiNum[] = $i;
		}
	}
	if ($iNum > 1) 		$aiNum[] = $iNum;
	return $aiNum;
}

function _getPrimeNumberString($callback, $strNumber)
{
    $fStart = microtime(true);
    $aiNum = call_user_func($callback, intval($strNumber));
	$str = $strNumber.'=';
	foreach ($aiNum as $iPrime)
	{
		$str .= strval($iPrime).'*';
	}
	return rtrim($str, '*').DebugGetStopWatchDisplay($fStart);
}

function GetPrimeNumberString($strNumber)
{
	$str = _getPrimeNumberString(_onePassPrimeNumber, $strNumber);
//	$str .= '<br />'._getPrimeNumberString(_lookUpPrimeNumber, $strNumber);
	return $str;
}

?>
