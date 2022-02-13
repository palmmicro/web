<?php

function RobloxDice($iNum, $iTarget)
{
	$arDisplay = array();
	$arDice = array();
	for ($i = 0; $i < $iNum; $i ++)		$arDice[] = 1;

    while (1)
    {
    	$iTotal = 0;
    	for ($i = 0; $i < $iNum; $i ++)	$iTotal += $arDice[$i];
    	if ($iTotal == $iTarget)			
    	{
//    		DebugPrint($arDice);
    		$arCopy = $arDice;
    		sort($arCopy);
    		$str = '';
    		for ($i = 0; $i < $iNum; $i ++)	$str .= strval($arCopy[$i]);
    		$arDisplay[] = $str;
    	}
		else if ($iTotal == $iNum * 6)		break; 
    	
    	for ($i = 0; $i < $iNum; $i ++)
    	{
    		for ($j = $i; $j < $iNum; $j ++)
    		{
    			if ($arDice[$j] < 6)
    			{
    				$arDice[$j] ++;
    				break;
    			}
    			else
    			{
    				if ($j == $iNum - 1)	break;
    				for ($k = 0; $k <= $j; $k ++)		$arDice[$k] = 1;
    			}
    		}
    		break;
    	}
    }
    
	return $arDisplay;
}

?>
