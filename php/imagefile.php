<?php

// ****************************** ImageFile class  *******************************************************
class ImageFile
{
    var $strPathName;
    var $iWidth;
    var $iHeight;
    
    var $image;
    
    var $textcolor;
    var $pixelcolor;
    var $dashedcolor;
    var $linecolor;
    var $comparecolor;
    
    var $strTextColor;
    var $strPixelColor;
    var $strDashedColor;
    var $strLineColor;
    var $strCompareColor;
    
    var $iFont;
    var $fFontSize;
    var $fFontAngle;
    var $strFontFile;
    
    public function __construct($strPathName, $iWidth, $iHeight) 
    {
        $this->strPathName = $strPathName;
        $this->iWidth = $iWidth;
        $this->iHeight = $iHeight;
        $this->image = imagecreatetruecolor($iWidth, $iHeight);
        
        $this->_set_text_color(255, 255, 255);
        $this->_set_pixel_color(0, 255, 255);
        $this->_set_dashed_color(255, 0, 255);
        $this->_set_line_color(255, 0, 0);
        $this->_set_compare_color(0, 255, 0);
        
        $this->iFont = 5;
        $this->fFontSize = 15.0;
        $this->fFontAngle = 0.0;
        $this->strFontFile = DebugGetFontName('simkai');
    }
 
    function _getColorString($r, $g, $b)
    {
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
        
    function _set_text_color($r, $g, $b)
    {
        $this->textcolor = imagecolorallocate($this->image, $r, $g, $b);
        $this->strTextColor = $this->_getColorString($r, $g, $b);
    }
    
    function _set_pixel_color($r, $g, $b)
    {
        $this->pixelcolor = imagecolorallocate($this->image, $r, $g, $b);
        $this->strPixelColor = $this->_getColorString($r, $g, $b);
    }
    
    function _set_dashed_color($r, $g, $b)
    {
        $this->dashedcolor = imagecolorallocate($this->image, $r, $g, $b);
        $this->strDashedColor = $this->_getColorString($r, $g, $b);
    }
    
    function _set_line_color($r, $g, $b)
    {
        $this->linecolor = imagecolorallocate($this->image, $r, $g, $b);
        $this->strLineColor = $this->_getColorString($r, $g, $b);
    }
    
    function _set_compare_color($r, $g, $b)
    {
        $this->comparecolor = imagecolorallocate($this->image, $r, $g, $b);
        $this->strCompareColor = $this->_getColorString($r, $g, $b);
    }
    
    function Text($x, $y, $strText)
    {
//        imagestring($this->image, $this->iFont, $x, $y, $strText, $this->textcolor);
		$ar = imagettfbbox($this->fFontSize, $this->fFontAngle, $this->strFontFile, $strText);
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
    
    function _line($x1, $y1, $x, $y, $color)
    {
    	imageline($this->image, $x1, $y1, $x, $y, $color);
    }
    
    function Line($x1, $y1, $x, $y)
    {
    	$this->_line($x1, $y1, $x, $y, $this->linecolor);
    }
    
    function CompareLine($x1, $y1, $x, $y)
    {
    	$this->_line($x1, $y1, $x, $y, $this->comparecolor);
    }
    
    function DashedLine($x1, $y1, $x, $y)
    {
    	$arStyle = array($this->dashedcolor, $this->dashedcolor, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT);
    	imagesetstyle($this->image, $arStyle);
    	imageline($this->image, $x1, $y1, $x, $y, IMG_COLOR_STYLED);
    }
    
    function PixelLine($x1, $y1, $x, $y)
    {
    	$this->_line($x1, $y1, $x, $y, $this->pixelcolor);
    }
    
 	function Pixel($x, $y)
    {
    	imagesetpixel($this->image, $x, $y, $this->pixelcolor);
    }
    
    function SaveFile()
    {
//    	unlinkEmptyFile($this->strPathName);
        imagejpeg($this->image, $this->strPathName);  
        imagedestroy($this->image);
    }
    
    function GetLink()
    {
    	$this->SaveFile();
    	$strRand = strval(rand());
		return GetImgElement(UrlGetPathName($this->strPathName).'?'.$strRand, $strRand.' automatical generated image, do NOT link');
    }

    function GetPathName()
    {
    	return $this->strPathName;
    }
}

class PageImageFile extends ImageFile
{
    var $fMaxX;
    var $fMinX = 0.0;
    var $fMaxY;
    var $fMinY = 0.0;

    public function __construct() 
    {
    	$iWidth = LayoutGetDisplayWidth();
		$iHeight = intval($iWidth * 360 / DEFAULT_WIDTH);
        parent::__construct(DebugGetImageName(UrlGetUniqueString()), $iWidth, $iHeight);
    }

    function _getPos($f, $fMax, $fMin)
    {
    	$fDiff = $fMax - $fMin;
    	if (abs($fDiff) > MIN_FLOAT_VAL)
    	{
    		return ($f - $fMin) / $fDiff;
    	}
    	return 0.0;
    }
    
    function GetPosX($fX = 0.0)
    {
		return intval($this->iWidth * $this->_getPos($fX, $this->fMaxX, $this->fMinX));
    }
    
    function GetPosY($fY = 0.0)
    {
		return intval($this->iHeight * (1.0 - $this->_getPos($fY, $this->fMaxY, $this->fMinY)));
    }
    
    function DrawAxisY($fVal = 0.0)
    {
    	if ($this->fMaxX > $fVal && $this->fMinX < $fVal)
    	{
    		$iPosX = $this->GetPosX($fVal);
    		$this->DashedLine($iPosX, 0, $iPosX, $this->iHeight);
    	}
    }
    
    function DrawAxisX($fVal = 0.0)
    {
    	if ($this->fMaxY > $fVal && $this->fMinY < $fVal)
    	{
    		$iPosY = $this->GetPosY($fVal);
    		$this->DashedLine(0, $iPosY, $this->iWidth, $iPosY);
    	}
    }
    
    function DrawPolyLine($ar, $callback = 'Line')
    {
    	$iCur = 0;
    	foreach ($ar as $strKey => $fVal)
    	{
    		$x = $this->GetPosX($iCur);                                                                 
    		$y = $this->GetPosY($fVal);
    		
   			if ($iCur != 0)
   			{
   				$this->$callback($x1, $y1, $x, $y);
   			}
   			$x1 = $x;
   			$y1 = $y;
    		$iCur ++;
    	}
    }
    
    function DrawComparePolyLine($ar)
    {
    	return $this->DrawPolyLine($ar, 'CompareLine');
    }
    
    function DrawPixelPolyLine($ar)
    {
    	return $this->DrawPolyLine($ar, 'PixelLine');
    }
    
    function DrawDashedPolyLine($ar)
    {
    	return $this->DrawPolyLine($ar, 'DashedLine');
    }
}

?>
