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
	return strval_round_implode(GetStandardBenfordArray($iTotal));
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
	var $fP2;
	var $fP3;
	
	var $iTotal;
	var $iTotal2;
	var $iTotal3;
	
    function Draw($arTarget, $arTarget2 = false)
    {
    	list($this->iTotal, $ar) = GetBenfordData($arTarget);
    	$this->fP = PearsonChiSquaredTest(GetStandardBenfordArray($this->iTotal), $ar);
    	if ($arTarget2)
    	{
    		list($this->iTotal2, $ar2) = GetBenfordData($arTarget2);
    		$this->fP2 = PearsonChiSquaredTest(GetStandardBenfordArray($this->iTotal2), $ar2);
    		
    		list($this->iTotal3, $ar3) = GetBenfordData(array_merge($arTarget, $arTarget2));
    		$this->fP3 = PearsonChiSquaredTest(GetStandardBenfordArray($this->iTotal3), $ar3);
    	}
    	
    	for ($i = 0; $i < 9; $i ++)
    	{
			$ar[$i] /= 1.0 * $this->iTotal;
			if ($arTarget2)
			{
				$ar2[$i] /= 1.0 * $this->iTotal2;
				$ar3[$i] /= 1.0 * $this->iTotal3;
			}
    	}
    	
    	$this->fMaxX = 8.0;
    	$this->fMaxY = max($ar);
    	if ($arTarget2)
    	{
    		$fMax2 = max(max($ar2), max($ar3));
    		if ($this->fMaxY < $fMax2)	$this->fMaxY = $fMax2;	
    	}
    	$arStandard = GetStandardBenfordArray();
    	if ($this->fMaxY < $arStandard[0])	$this->fMaxY = $arStandard[0];	

    	for ($i = 0; $i < 9; $i ++)
    	{
			$this->Text($this->GetPosX($i), $this->GetPosY(), strval($i + 1));
    	}
    	
    	$this->DrawDashedPolyLine($arStandard);
    	$this->DrawPolyLine($ar);
    	if ($arTarget2)
    	{
    		$this->DrawComparePolyLine($ar2);
    		$this->DrawPixelPolyLine($ar3);
    	}
    }

    function _getText($strLine, $strColor, $iTotal, $fP)
    {
		$str = GetFontElement($strLine.'('.strval($iTotal).')', $strColor);
   		if ($fP)
   		{
   			$str .= ' P = '.strval_round($fP);
   		}
   		return $str;
    }
    
    function GetAll($strLine = '', $strCompare = false, $strCombine = false)
    {
		$str = $this->_getText($strLine, $this->strLineColor, $this->iTotal, $this->fP);
   		if ($strCompare)
   		{
   			$str .= '<br />'.$this->_getText($strCompare, $this->strCompareColor, $this->iTotal2, $this->fP2);
   			if ($strCombine)
   			{
   				$str .= '<br />'.$this->_getText($strCombine, $this->strPixelColor, $this->iTotal3, $this->fP3);
   			}
   		}
    	$str .= '<br />'.$this->GetLink();
    	return $str;
	}
}

?>
