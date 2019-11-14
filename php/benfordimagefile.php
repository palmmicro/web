<?php
require_once('imagefile.php');

function GetStandardBenfordArray()
{
	$ar = array();
	for ($i = 1; $i <= 9; $i ++)
	{
		$ar[] = log10(1.0 + 1.0 / $i);
	}
	return $ar;
}

function GetStandardBenfordData()
{
	return strval_round_implode(GetStandardBenfordArray(), '; ');
}

function GetBenfordData($ar)
{
	$arCount = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
	
	$iTotal = 0;
	foreach ($ar as $str)
	{
		while (!empty($str))
		{
			$strFirst = substr($str, 0, 1);
			if (ctype_digit($strFirst))
			{
				if ($strFirst != '0')
				{
					$iTotal ++;
					$arCount[intval($strFirst) - 1] += 1.0;
					break;
				}
			}
			$str = ltrim($str, $strFirst);
		}
	}

	for ($i = 0; $i < 9; $i ++)
	{
		$arCount[$i] /= $iTotal;
	}
	
	return $arCount;
}

class BenfordImageFile extends PageImageFile
{
    function BenfordImageFile() 
    {
        parent::PageImageFile();
    }
    
    function Draw($arTarget)
    {
    	$ar = GetBenfordData($arTarget);
    	$arStandard = GetStandardBenfordArray();
    	
    	$this->fMaxX = 8.0;
    	$this->fMinX = 0.0;
    	
    	$this->fMaxY = max($ar);
    	if ($this->fMaxY < $arStandard[0])	$this->fMaxY = $arStandard[0];	
    	$this->fMinY = 0.0;

    	for ($i = 0; $i < 9; $i ++)
    	{
    		$x = $this->GetPosX($i);                                                                 
    		$y = $this->GetPosY($arStandard[$i]);
    		
   			if ($i != 0)
   			{
   				$this->CompareLine($x1, $y1, $x, $y);
   			}
   			$x1 = $x;
   			$y1 = $y;
    	}
    	
    	for ($i = 0; $i < 9; $i ++)
    	{
    		$x = $this->GetPosX($i);                                                                 
    		$y = $this->GetPosY($ar[$i]);
    		
   			if ($i != 0)
   			{
   				$this->Line($x1, $y1, $x, $y);
   			}
   			$x1 = $x;
   			$y1 = $y;
    	}
    }
}

?>
