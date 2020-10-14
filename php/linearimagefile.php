<?php
require_once('imagefile.php');
require_once('internallink.php');
require_once('tutorial/math.php');

class LinearImageFile extends PageImageFile
{
    var $fA;
    var $fB;
    var $fR;
    
    function LinearImageFile($strIndex = '1') 
    {
        parent::PageImageFile($strIndex);
    }

    function Draw($arX, $arY)
    {
    	$iCount = count($arX);
    	if ($iCount < 2)	return false;
    	
    	list($this->fA, $this->fB, $this->fR) = LinearRegression($arX, $arY);
    	
    	$this->fMaxX = max($arX);
    	if ($this->fMaxX < 0.0)		$this->fMaxX = 0.0;
    	$this->fMinX = min($arX);
    	if ($this->fMinX > 0.0)		$this->fMinX = 0.0;
    	$this->DrawAxisY();
    	
    	$this->fMaxY = max($arY);
    	if ($this->fMaxY < 0.0)		$this->fMaxY = 0.0;
    	$this->fMinY = min($arY);
    	if ($this->fMinY > 0.0)		$this->fMinY = 0.0;
    	$this->DrawAxisX();
    	
    	// y = A + B * x;
    	$this->Line($this->GetPosX($this->fMinX), $this->GetPosY($this->GetY($this->fMinX)), $this->GetPosX($this->fMaxX), $this->GetPosY($this->GetY($this->fMaxX)));
    	
    	$bStar = ($iCount < $this->iWidth / 2) ? true : false;
    	foreach ($arX as $strKey => $fX)
    	{
    		$x = $this->GetPosX($fX);
    		$y = $this->GetPosY($arY[$strKey]);
			if ($bStar)	$this->Text($x, $y, '*');
			else			$this->Pixel($x, $y);
    	}
    	
    	return true;
    }
    
    function GetY($fX)
    {
    	return $this->fA + $this->fB * $fX;
    }
    
    function GetEquation()
    {
    	$str = 'y = '.strval_round($this->fA);
    	if ($this->fB < 0.0)
    	{
    	}
    	else
    	{
    		$str .= ' + ';
    	}
    	return $str.strval_round($this->fB).' * x; r =  '.strval_round($this->fR);
    }
    
    function GetAllLinks()
    {
    	return GetLinearRegressionLink().'<br />'.$this->GetEquation().'<br />'.$this->GetLink();
    }
}

?>
