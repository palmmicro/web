<?php
require_once('tutorial/math.php');

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
    
    var $strLineColor;
    var $strCompareColor;
    
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
        $this->pixelcolor = imagecolorallocate($this->image, 0, 255, 255);
        $this->dashedcolor = imagecolorallocate($this->image, 255, 0, 255);
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
		return '<img src='.$this->strPathName.'?'.$strRand.' alt="'.$strRand.' automatical generated image, do NOT link" />';
    }
    
    function EchoFile($str)
    {
    	$strLink = $this->GetLink();
    	EchoParagraph($str.'<br />'.$strLink);
	}
	
    function GetPathName()
    {
    	return $this->strPathName;
    }
}

class PageImageFile extends ImageFile
{
    var $fMaxX;
    var $fMinX;
    var $fMaxY;
    var $fMinY;

    function PageImageFile() 
    {
        parent::ImageFile(DebugGetImageName(UrlGetUniqueString()), 640, 480);
    }

    function _getPos($f, $fMax, $fMin)
    {
    	return ($f - $fMin) / ($fMax - $fMin);
    }
    
    function _getPosX($fX)
    {
		return intval($this->iWidth * $this->_getPos($fX, $this->fMaxX, $this->fMinX));
    }
    
    function _getPosY($fY)
    {
		return intval($this->iHeight * (1.0 - $this->_getPos($fY, $this->fMaxY, $this->fMinY)));
    }
    
    function _drawAxisX()
    {
    	if ($this->fMaxX > 0.0 && $this->fMinX < 0.0)
    	{
    		$iPosX = $this->_getPosX(0.0);
    		$this->DashedLine($iPosX, 0, $iPosX, $this->iHeight);
    	}
    }
    
    function _drawAxisY()
    {
    	if ($this->fMaxY > 0.0 && $this->fMinY < 0.0)
    	{
    		$iPosY = $this->_getPosY(0.0);
    		$this->DashedLine(0, $iPosY, $this->iWidth, $iPosY);
    	}
    }
}

class LinearImageFile extends PageImageFile
{
    var $fA;
    var $fB;
    var $fR;
    
    function LinearImageFile() 
    {
        parent::PageImageFile();
    }

    function Draw($arX, $arY)
    {
    	list($this->fA, $this->fB, $this->fR) = LinearRegression($arX, $arY);
    	
    	$this->fMaxX = max($arX);
    	if ($this->fMaxX < 0.0)		$this->fMaxX = 0.0;
    	$this->fMinX = min($arX);
    	if ($this->fMinX > 0.0)		$this->fMinX = 0.0;
    	$this->_drawAxisX();
    	
    	$this->fMaxY = max($arY);
    	if ($this->fMaxY < 0.0)		$this->fMaxY = 0.0;
    	$this->fMinY = min($arY);
    	if ($this->fMinY > 0.0)		$this->fMinY = 0.0;
    	$this->_drawAxisY();
    	
    	// y = A + B * x;
    	$this->Line($this->_getPosX($this->fMinX), $this->_getPosY($this->GetY($this->fMinX)), $this->_getPosX($this->fMaxX), $this->_getPosY($this->GetY($this->fMaxX)));
    	
    	$bStar = (count($arX) < $this->iWidth / 2) ? true : false;
    	foreach ($arX as $strKey => $fX)
    	{
    		$x = $this->_getPosX($fX);
    		$y = $this->_getPosY($arY[$strKey]);
			if ($bStar)	$this->Text($x, $y, '*');
			else			$this->Pixel($x, $y);
    	}
    }
    
    function GetEquation()
    {
    	$str = 'Y = '.strval_round($this->fA);
    	if ($this->fB < 0.0)
    	{
    	}
    	else
    	{
    		$str .= ' + ';
    	}
    	return $str.strval_round($this->fB).' * X; R =  '.strval_round($this->fR);
    }
    
    function GetY($fX)
    {
    	return $this->fA + $this->fB * $fX;
    }
}

class DateImageFile extends PageImageFile
{
	var $strText;
	
    function DateImageFile() 
    {
        parent::PageImageFile();
        $this->strText = '';
    }
    
    function _textDateVal($str, $strDate, $fVal)
    {
		$this->strText .= $str.': '.$strDate.' '.strval($fVal).'<br />';
    }
    
    function DrawDateArray($ar)
    {
    	$ar = array_reverse($ar);	// ksort($ar);
    	reset($ar);
    	$this->_textDateVal('开始', key($ar), current($ar));
    	end($ar);
    	$this->_textDateVal('结束', key($ar), current($ar));

    	$this->fMaxX = count($ar);
    	$this->fMinX = 0.0;
    	
    	$this->fMaxY = max($ar);
		$this->_textDateVal('最大', array_search($this->fMaxY, $ar), $this->fMaxY);
    	if ($this->fMaxY < 0.0)		$this->fMaxY = 0.0;
    	$this->fMinY = min($ar);
		$this->_textDateVal('最小', array_search($this->fMinY, $ar), $this->fMinY);
    	if ($this->fMinY > 0.0)		$this->fMinY = 0.0;
    	$this->_drawAxisY();

    	$iCur = 0;
    	$iMaxPos = false;
    	$iMinPos = false;
    	foreach ($ar as $strDate => $fVal)
    	{
			$x = $this->_getPosX($iCur);
    		$y = $this->_getPosY($fVal);
    		
   			if ($iCur != 0)
   			{
   				$this->Line($x1, $y1, $x, $y);
   			}
   			$x1 = $x;
   			$y1 = $y;
    		$iCur ++;
    	}
    }

    function DrawCompareArray($ar)
    {
    	$this->fMaxX = count($ar);
    	$this->fMinX = 0.0;
    	$this->fMaxY = max($ar);
    	$this->fMinY = 0.0;

    	$ar = array_reverse($ar);
    	$iCur = 0;
    	foreach ($ar as $strDate => $fVal)
    	{
    		$x = $this->_getPosX($iCur);                                                                 
    		$y = $this->_getPosY($fVal);
    		
   			if ($iCur != 0)
   			{
   				$this->CompareLine($x1, $y1, $x, $y);
   			}
   			$x1 = $x;
   			$y1 = $y;
    		$iCur ++;
    	}
    }

    function Show($strName, $strCompare, $strLinks)
    {
    	$strLinks .= '<br />'.$this->strText;
    	$strLinks .= "<font color={$this->strLineColor}>$strName</font> <font color={$this->strCompareColor}>$strCompare</font>";
    	$this->EchoFile($strLinks);
	}
}

?>
