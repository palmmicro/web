<?php
require_once('/php/debug.php');
require_once('/php/sql/sqltable.php');

function _lookUpPrimeNumber($iNum)
{
	$pn_sql = new TableSql('primenumber');
	if ($pn_sql->CountData() == 0)
	{
		$aiPrime = array();
		for ($i = 2; ($i * $i) <= PHP_INT_MAX; $i ++)
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
			if ($bPrime)
			{
				$aiPrime[] = $i;
				$pn_sql->InsertId(strval($i));
			}
		}
	}

	$aiNum = array();
    if ($result = $pn_sql->GetByMaxId(intval(sqrt($iNum))))
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$iPrime = intval($record['id']);
        	if ($iPrime * $iPrime > $iNum)	break;
        	while (($iNum % $iPrime) == 0)
        	{
        		$iNum /= $iPrime;
        		$aiNum[] = $iPrime;
        	}
        }
        if ($iNum > 1) 		$aiNum[] = $iNum;
        @mysql_free_result($result);
    }
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
	return rtrim($str, '*').DebugGetStopWatchDisplay($fStart, 4);
}

function GetPrimeNumberString($strNumber)
{
	$str = _getPrimeNumberString('_onePassPrimeNumber', $strNumber);
	$str .= '<br />'._getPrimeNumberString('_lookUpPrimeNumber', $strNumber);
	return $str;
}

?>
