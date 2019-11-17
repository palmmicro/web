<?php
require_once('imagefile.php');
require_once('tutorial/math.php');

function GetStandardBenfordArray($iTotal = 1)
{
	$ar = array();
	for ($i = 1; $i <= 9; $i ++)
	{
		$ar[] = log10(1.0 + 1.0 / $i) * $iTotal;
	}
	return $ar;
}

function GetStandardBenfordData($iTotal = 1)
{
	return strval_round_implode(GetStandardBenfordArray($iTotal), '; ');
}

function GetBenfordData($ar)
{
	$arCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
	
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
					$arCount[intval($strFirst) - 1] ++;
					break;
				}
			}
			$str = ltrim($str, $strFirst);
		}
	}

	return array($iTotal, $arCount);
}

class BenfordImageFile extends PageImageFile
{
	var $fP;
	var $iTotal;
	
    function BenfordImageFile() 
    {
        parent::PageImageFile();
    }
    
    function GetP()
    {
    	return $this->fP;
    }
    
    function GetTotal()
    {
    	return $this->iTotal;
    }
    
    function Draw($arTarget)
    {
    	list($this->iTotal, $ar) = GetBenfordData($arTarget);
    	$arStandard = GetStandardBenfordArray($this->iTotal);
    	
    	$this->fP = PearsonChiSquaredTest($arStandard, $ar);
    	
    	$this->fMaxX = 8.0;
    	$this->fMaxY = max($ar);
    	if ($this->fMaxY < $arStandard[0])	$this->fMaxY = $arStandard[0];	

    	for ($i = 0; $i < 9; $i ++)
    	{
    		$x = $this->GetPosX($i);
			$this->Text($x, $this->GetPosY(), strval($i + 1));
			$this->Text($x, $this->GetPosY($this->fMaxY), $ar[$i]);
    	}
    	
    	$this->DrawComparePolyLine($arStandard);
    	$this->DrawPolyLine($ar);
    }

    function GetAll()
    {
   		$str = strval($this->GetTotal());
    	if ($fP = $this->GetP())
    	{
    		$str .= '<br />P = '.strval_round($fP);
    	}
    	$str .= '<br />'.$this->GetLink();
    	return $str;
	}
}

?>
