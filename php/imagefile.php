<?php

// ****************************** ImageFile class  *******************************************************
class ImageFile
{
    var $strPathName;
    var $iWidth;
    var $iHeight;
    
    var $image;
    
    var $textcolor;
    var $linecolor;
    var $pixelcolor;
    
    var $iFont;
    var $fFontSize;
    var $fFontAngle;
    var $strFontFile;
    
    function ImageFile($strPathName, $iWidth, $iHeight) 
    {
        $this->strPathName = $strPathName;
        $this->iWidth = $iWidth;
        $this->iHeight = $iHeight;
        $this->image = imagecreatetruecolor($iWidth, $iHeight);
        
        $this->textcolor = imagecolorallocate($this->image, 255, 255, 255);
        $this->linecolor = imagecolorallocate($this->image, 255, 0, 0);
        $this->pixelcolor = imagecolorallocate($this->image, 0, 255, 0);
        
        $this->iFont = 5;
        $this->fFontSize = 15.0;
        $this->fFontAngle = 0.0;
        $this->strFontFile = DebugGetFontName('simkai');
    }
    
    function Text($x, $y, $strText)
    {
//        imagestring($this->image, $this->iFont, $x, $y, $strText, $this->textcolor);
		$ar = imagettfbbox($this->fFontSize, $this->fFontAngle, $this->strFontFile, $strText);
/*		DebugString($strText);
		foreach ($ar as $iVal)
		{
			DebugVal($iVal);
		}*/
		$iMin = min($ar[0], $ar[6]);
		if ($x + $iMin < 0)					$x = 1 - $iMin;
		$iMax = max($ar[2], $ar[4]);
		if ($x + $iMax > $this->iWidth)		$x = $this->iWidth - $iMax - 2;
		$iMin = min($ar[5], $ar[7]);
		if ($y + $iMin < 0)					$y = 1 - $iMin;
		$iMax = max($ar[3], $ar[1]);
		if ($y + $iMax > $this->iHeight)		$y = $this->iHeight - $iMax - 2;
		return imagettftext($this->image, $this->fFontSize, $this->fFontAngle, $x, $y, $this->textcolor, $this->strFontFile, $strText);
    }
    
    function Line($x1, $y1, $x, $y)
    {
    	imageline($this->image, $x1, $y1, $x, $y, $this->linecolor);
    }
    
    function Pixel($x, $y)
    {
    	imagesetpixel($this->image, $x, $y, $this->pixelcolor);
    }
    
    function DrawDateArray($ar)
    {
    	ksort($ar);
    	reset($ar);
    	$iBottom = $this->iHeight;
    	$this->Text(0, $iBottom, key($ar));
    	end($ar);
    	$arPos = $this->Text($this->iWidth, $iBottom, key($ar));
    	$iBottom = min($arPos[5], $arPos[7]);
    	$iTextHeight = $this->iHeight - $iBottom + 1;
    	
    	$fMax = max($ar);
    	$fMin = min($ar);
    	$iBottom -= $iTextHeight;
    	
    	$iCount = count($ar);
    	$iCur = 0;
    	$iMaxPos = false;
    	$iMinPos = false;
    	foreach ($ar as $strDate => $fVal)
    	{
    		$x = intval($this->iWidth * $iCur / $iCount);                                                                 
    		$y = intval(($iBottom - $iTextHeight) * ($fVal - $fMax) / ($fMin - $fMax)) + $iTextHeight;
   			if ($iMaxPos == false && abs($fVal - $fMax) < 0.000001)
    		{
   				$this->Text($x, 0, strval($fMax).' '.$strDate);
   				$iMaxPos = $iCur;
    		}
    		if ($iMinPos == false && abs($fVal - $fMin) < 0.000001)
    		{
   				$this->Text($x, $iBottom, strval($fMin).' '.$strDate);
   				$iMinPos = $iCur;
    		}
    		
   			if ($iCur != 0)	$this->Line($x1, $y1, $x, $y);
   			$x1 = $x;
   			$y1 = $y;
    		$iCur ++;
    	}
    }
                                             
    function SaveFile()
    {
//    	unlinkEmptyFile($this->strPathName);
        imagejpeg($this->image, $this->strPathName);  
        imagedestroy($this->image);
    }
    
    function GetPathName()
    {
    	return $this->strPathName;
    }
}

class PageImageFile extends ImageFile
{
    function PageImageFile() 
    {
        parent::ImageFile(DebugGetImageName(UrlGetUniqueString()), 640, 480);
    }
}

?>
