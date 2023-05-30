<?php

function LookUpPrimeNumber($iNum)
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
        while ($record = mysqli_fetch_assoc($result)) 
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
        mysqli_free_result($result);
    }
	return $aiNum;
}

function OnePassPrimeNumber($iNum)
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

?>
